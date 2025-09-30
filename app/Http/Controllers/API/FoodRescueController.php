<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FoodRescue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class FoodRescueController extends Controller
{
    /**
     * Display a listing of food rescue offers.
     */
    public function index(Request $request)
    {
        try {
            $query = FoodRescue::available()->with(['vendor']);

            // Filter by vendor if specified
            if ($request->vendor_id) {
                $query->where('vendor_id', $request->vendor_id);
            }

            // Filter by vendor type if specified
            if ($request->vendor_type_id) {
                $query->whereHas('vendor', function ($q) use ($request) {
                    $q->where('vendor_type_id', $request->vendor_type_id);
                });
            }

            // Search functionality
            if ($request->keyword) {
                $query->where(function ($q) use ($request) {
                    $q->whereRaw('title LIKE ?', ["%{$request->keyword}%"])
                      ->orWhereRaw('description LIKE ?', ["%{$request->keyword}%"]);
                });
            }

            // Filter by tags
            if ($request->tags) {
                $tags = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
                $query->where(function ($q) use ($tags) {
                    foreach ($tags as $tag) {
                        $q->orWhereJsonContains('tags', trim($tag));
                    }
                });
            }

            // Filter by location (nearby offers)
            if ($request->latitude && $request->longitude) {
                $radius = $request->radius ?? 10; // Default 10km radius
                $query->nearby($request->latitude, $request->longitude, $radius);
            }

            // Filter by price range
            if ($request->min_price) {
                $query->where('rescue_price', '>=', $request->min_price);
            }
            if ($request->max_price) {
                $query->where('rescue_price', '<=', $request->max_price);
            }

            // Filter by availability time
            if ($request->available_today) {
                $query->where(function ($q) {
                    $q->whereNull('available_until')
                      ->orWhere('available_until', '>=', now()->endOfDay());
                });
            }

            // Sorting options
            switch ($request->sort_by) {
                case 'price_low':
                    $query->orderBy('rescue_price', 'ASC');
                    break;
                case 'price_high':
                    $query->orderBy('rescue_price', 'DESC');
                    break;
                case 'discount':
                    $query->orderByRaw('((original_price - rescue_price) / original_price * 100) DESC');
                    break;
                case 'ending_soon':
                    $query->whereNotNull('available_until')
                          ->orderBy('available_until', 'ASC');
                    break;
                case 'distance':
                    if ($request->latitude && $request->longitude) {
                        // Distance sorting is handled in the nearby scope
                    }
                    break;
                default:
                    $query->orderBy('created_at', 'DESC');
                    break;
            }

            // For vendor app - show only their own offers
            $user = User::find(auth('sanctum')->id());
            if ($user && $user->hasRole('manager') && $request->type === 'vendor') {
                $query->where('vendor_id', $user->vendor_id);
                // Remove availability filter for vendor's own offers
                $query = FoodRescue::where('vendor_id', $user->vendor_id)->with(['vendor']);
            }

            $perPage = $request->per_page ?? 20;
            $foodRescues = $query->paginate($perPage);

            return response()->json($foodRescues, 200);
        } catch (Exception $ex) {
            logger("Food Rescue Index Error", [$ex]);
            return response()->json([
                'message' => __('Failed to fetch food rescue offers')
            ], 500);
        }
    }

    /**
     * Display the specified food rescue offer.
     */
    public function show(Request $request, $id)
    {
        try {
            $foodRescue = FoodRescue::with(['vendor'])->findOrFail($id);
            
            return response()->json($foodRescue, 200);
        } catch (Exception $ex) {
            return response()->json([
                'message' => __('Food rescue offer not found')
            ], 404);
        }
    }

    /**
     * Store a newly created food rescue offer (Vendor App).
     */
    public function store(Request $request)
    {
        $user = User::find(auth('sanctum')->id());
        
        // Check if user is a manager
        if (!$user || !$user->hasRole('manager')) {
            return response()->json([
                'message' => __('You are not authorized to perform this operation')
            ], 403);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'original_price' => 'required|numeric|min:0',
            'rescue_price' => 'required|numeric|min:0',
            'available_quantity' => 'required|integer|min:1',
            'total_quantity' => 'required|integer|min:1',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date|after:available_from',
            'pickup_instructions' => 'nullable|string',
            'tags' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => __('Validation failed'),
                'errors' => $validator->errors()
            ], 422);
        }

        // Additional validation
        if ($request->rescue_price > $request->original_price) {
            return response()->json([
                'message' => __('Rescue price cannot be higher than original price')
            ], 422);
        }

        try {
            DB::beginTransaction();

            $foodRescue = new FoodRescue();
            $foodRescue->title = $request->title;
            $foodRescue->description = $request->description;
            $foodRescue->original_price = $request->original_price;
            $foodRescue->rescue_price = $request->rescue_price;
            $foodRescue->available_quantity = $request->available_quantity;
            $foodRescue->total_quantity = max($request->total_quantity, $request->available_quantity);
            $foodRescue->available_from = $request->available_from;
            $foodRescue->available_until = $request->available_until;
            $foodRescue->vendor_id = $user->vendor_id;
            $foodRescue->is_active = $request->is_active ?? true;
            $foodRescue->pickup_instructions = $request->pickup_instructions;
            $foodRescue->tags = $request->tags ?? [];
            $foodRescue->save();

            // Handle photo uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $foodRescue->addMedia($photo->getRealPath())
                        ->usingFileName(genFileName($photo))
                        ->toMediaCollection('default');
                }
            } elseif ($request->hasFile('photo')) {
                $foodRescue->addMedia($request->photo->getRealPath())
                    ->usingFileName(genFileName($request->photo))
                    ->toMediaCollection('default');
            }

            DB::commit();

            return response()->json([
                'message' => __('Food rescue offer created successfully'),
                'data' => $foodRescue->load('vendor')
            ], 201);
        } catch (Exception $ex) {
            DB::rollback();
            logger("Food Rescue Creation Error", [$ex]);
            return response()->json([
                'message' => __('Failed to create food rescue offer')
            ], 500);
        }
    }

    /**
     * Update the specified food rescue offer (Vendor App).
     */
    public function update(Request $request, $id)
    {
        $user = User::find(auth('sanctum')->id());
        
        try {
            $foodRescue = FoodRescue::findOrFail($id);
            
            // Check if user owns this food rescue offer
            if (!$user || !$user->hasRole('manager') || $user->vendor_id != $foodRescue->vendor_id) {
                return response()->json([
                    'message' => __('You are not authorized to perform this operation')
                ], 403);
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'original_price' => 'sometimes|required|numeric|min:0',
                'rescue_price' => 'sometimes|required|numeric|min:0',
                'available_quantity' => 'sometimes|required|integer|min:0',
                'total_quantity' => 'sometimes|required|integer|min:1',
                'available_from' => 'nullable|date',
                'available_until' => 'nullable|date|after:available_from',
                'pickup_instructions' => 'nullable|string',
                'tags' => 'nullable|array',
                'photos' => 'nullable|array',
                'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => __('Validation failed'),
                    'errors' => $validator->errors()
                ], 422);
            }

            // Additional validation
            if ($request->has('rescue_price') && $request->has('original_price') && 
                $request->rescue_price > $request->original_price) {
                return response()->json([
                    'message' => __('Rescue price cannot be higher than original price')
                ], 422);
            }

            DB::beginTransaction();

            // Update fields
            if ($request->has('title')) $foodRescue->title = $request->title;
            if ($request->has('description')) $foodRescue->description = $request->description;
            if ($request->has('original_price')) $foodRescue->original_price = $request->original_price;
            if ($request->has('rescue_price')) $foodRescue->rescue_price = $request->rescue_price;
            if ($request->has('available_quantity')) $foodRescue->available_quantity = $request->available_quantity;
            if ($request->has('total_quantity')) {
                $foodRescue->total_quantity = max($request->total_quantity, $foodRescue->available_quantity);
            }
            if ($request->has('available_from')) $foodRescue->available_from = $request->available_from;
            if ($request->has('available_until')) $foodRescue->available_until = $request->available_until;
            if ($request->has('is_active')) $foodRescue->is_active = $request->is_active;
            if ($request->has('pickup_instructions')) $foodRescue->pickup_instructions = $request->pickup_instructions;
            if ($request->has('tags')) $foodRescue->tags = $request->tags;
            
            $foodRescue->save();

            // Handle photo uploads
            if ($request->hasFile('photos')) {
                $foodRescue->clearMediaCollection('default');
                foreach ($request->file('photos') as $photo) {
                    $foodRescue->addMedia($photo->getRealPath())
                        ->usingFileName(genFileName($photo))
                        ->toMediaCollection('default');
                }
            } elseif ($request->hasFile('photo')) {
                $foodRescue->clearMediaCollection('default');
                $foodRescue->addMedia($request->photo->getRealPath())
                    ->usingFileName(genFileName($request->photo))
                    ->toMediaCollection('default');
            }

            DB::commit();

            return response()->json([
                'message' => __('Food rescue offer updated successfully'),
                'data' => $foodRescue->load('vendor')
            ], 200);
        } catch (Exception $ex) {
            DB::rollback();
            logger("Food Rescue Update Error", [$ex]);
            return response()->json([
                'message' => __('Failed to update food rescue offer')
            ], 500);
        }
    }

    /**
     * Remove the specified food rescue offer (Vendor App).
     */
    public function destroy($id)
    {
        $user = User::find(auth('sanctum')->id());
        
        try {
            $foodRescue = FoodRescue::findOrFail($id);
            
            // Check if user owns this food rescue offer
            if (!$user || !$user->hasRole('manager') || $user->vendor_id != $foodRescue->vendor_id) {
                return response()->json([
                    'message' => __('You are not authorized to perform this operation')
                ], 403);
            }

            DB::beginTransaction();
            $foodRescue->delete();
            DB::commit();

            return response()->json([
                'message' => __('Food rescue offer deleted successfully')
            ], 200);
        } catch (Exception $ex) {
            DB::rollback();
            logger("Food Rescue Deletion Error", [$ex]);
            return response()->json([
                'message' => __('Failed to delete food rescue offer')
            ], 500);
            }
    }

    /**
     * Get nearby food rescue offers.
     */
    public function nearby(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => __('Invalid location parameters'),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $radius = $request->radius ?? 10;
            
            $foodRescues = FoodRescue::available()
                ->with(['vendor'])
                ->nearby($request->latitude, $request->longitude, $radius)
                ->orderBy('created_at', 'DESC')
                ->paginate($request->per_page ?? 20);

            return response()->json($foodRescues, 200);
        } catch (Exception $ex) {
            logger("Food Rescue Nearby Error", [$ex]);
            return response()->json([
                'message' => __('Failed to fetch nearby food rescue offers')
            ], 500);
        }
    }

    /**
     * Mark food rescue offer as purchased (decrease quantity).
     */
    public function purchase(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => __('Invalid quantity'),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $foodRescue = FoodRescue::findOrFail($id);
            
            if (!$foodRescue->is_available) {
                return response()->json([
                    'message' => __('This food rescue offer is no longer available')
                ], 400);
            }

            if ($foodRescue->available_quantity < $request->quantity) {
                return response()->json([
                    'message' => __('Not enough quantity available')
                ], 400);
            }

            DB::beginTransaction();
            $success = $foodRescue->decreaseQuantity($request->quantity);
            
            if (!$success) {
                DB::rollback();
                return response()->json([
                    'message' => __('Failed to update quantity')
                ], 400);
            }

            DB::commit();

            return response()->json([
                'message' => __('Quantity updated successfully'),
                'available_quantity' => $foodRescue->available_quantity
            ], 200);
        } catch (Exception $ex) {
            DB::rollback();
            logger("Food Rescue Purchase Error", [$ex]);
            return response()->json([
                'message' => __('Failed to process purchase')
            ], 500);
        }
    }
}
