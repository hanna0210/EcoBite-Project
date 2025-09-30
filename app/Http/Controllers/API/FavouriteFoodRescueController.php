<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\FoodRescue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class FavouriteFoodRescueController extends Controller
{
    /**
     * Display a listing of favourite food rescues.
     */
    public function index(Request $request)
    {
        try {
            $favourites = Favourite::with(['foodRescue.vendor'])
                ->where('user_id', Auth::id())
                ->whereNotNull('food_rescue_id')
                ->latest()
                ->paginate($request->per_page ?? 20);

            return response()->json($favourites, 200);
        } catch (Exception $ex) {
            logger("Favourite Food Rescue Index Error", [$ex]);
            return response()->json([
                'message' => __('Failed to fetch favourite food rescues')
            ], 500);
        }
    }

    /**
     * Store a newly created favourite food rescue.
     */
    public function store(Request $request)
    {
        $request->validate([
            'food_rescue_id' => 'required|exists:food_rescues,id'
        ]);

        try {
            // Check if already favourited
            $existingFavourite = Favourite::where('user_id', Auth::id())
                ->where('food_rescue_id', $request->food_rescue_id)
                ->first();

            if ($existingFavourite) {
                return response()->json([
                    'message' => __('Food rescue already in favourites')
                ], 400);
            }

            // Create new favourite
            $favourite = new Favourite();
            $favourite->user_id = Auth::id();
            $favourite->food_rescue_id = $request->food_rescue_id;
            $favourite->save();

            return response()->json([
                'message' => __('Food rescue added to favourites'),
                'data' => $favourite->load('foodRescue.vendor')
            ], 201);
        } catch (Exception $ex) {
            logger("Favourite Food Rescue Creation Error", [$ex]);
            return response()->json([
                'message' => __('Failed to add food rescue to favourites')
            ], 500);
        }
    }

    /**
     * Remove the specified favourite food rescue.
     */
    public function destroy($id)
    {
        try {
            $favourite = Favourite::where('user_id', Auth::id())
                ->where('food_rescue_id', $id)
                ->first();

            if (!$favourite) {
                return response()->json([
                    'message' => __('Food rescue not found in favourites')
                ], 404);
            }

            $favourite->delete();

            return response()->json([
                'message' => __('Food rescue removed from favourites')
            ], 200);
        } catch (Exception $ex) {
            logger("Favourite Food Rescue Deletion Error", [$ex]);
            return response()->json([
                'message' => __('Failed to remove food rescue from favourites')
            ], 500);
        }
    }
}
