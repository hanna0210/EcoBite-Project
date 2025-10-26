<?php

namespace App\Http\Livewire\Extensions\DriverLiveTracking;

use Illuminate\Support\Facades\Schema;
use App\Models\NavMenu;

class Installer
{

    public function run()
    {
        //
        $this->deleteUneededData();
        $this->createNavMenus();
        $this->modDB();
        //add view-driver-tracking permission to admin & city-admin roles
        $this->modPermissions();
        //add the routes to the extensions
        $this->createExtensionRoutes();
    }


    public function deleteUneededData()
    {
        //App\Http\Livewire\Extensions\DriverLiveTracking\Livewires\DriverLiveTrackingExtension.php
        try {
            unlink(base_path('app/Http/Livewire/Extensions/DriverLiveTracking/Livewires/DriverLiveTrackingExtension.php'));
        } catch (\Exception $e) {
            //do nothing
        }
    }

    //
    public function createNavMenus()
    {
        if (!Schema::hasTable('nav_menus')) {
            Schema::create('nav_menus', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('route');
                $table->string('roles')->nullable();
                $table->string('icon');
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('nav_menus', "roles")) {
            Schema::table('nav_menus', function ($table) {
                $table->string('roles')->after('route')->nullable();
            });
        }
    }

    public function modDB()
    {

        //add permissions column to the nav_menus table if not exists
        if (!Schema::hasColumn('nav_menus', 'permissions')) {
            Schema::table('nav_menus', function ($table) {
                $table->string('permissions')->after('roles')->nullable();
            });
        }

        $navMenu = NavMenu::where('route', 'driver.tracking')->first();
        if (empty($navMenu)) {
            \DB::table('nav_menus')->insert(array(
                0 =>
                array(
                    'name' => 'Driver Tracking',
                    'route' => 'driver.tracking',
                    'roles' => '',
                    'permissions' => "view-driver-tracking",
                    'icon' => 'heroicon-o-location-marker',
                ),
            ));
        } else {
            //update the nav menu
            //set roles to null
            //set permissions to view-driver-tracking
            $navMenu->roles = null;
            $navMenu->permissions = "view-driver-tracking";
            $navMenu->save();
        }
    }


    public function modPermissions()
    {
        $adminRole = \Spatie\Permission\Models\Role::where('name', 'admin')->first();
        $cityAdminRole = \Spatie\Permission\Models\Role::where('name', 'city-admin')->first();
        $viewDriverTrackingPermission = \Spatie\Permission\Models\Permission::where('name', 'view-driver-tracking')->first();
        if (empty($viewDriverTrackingPermission)) {
            \Spatie\Permission\Models\Permission::create(['name' => 'view-driver-tracking']);
        }

        if (!empty($adminRole)) {
            $adminRole->givePermissionTo('view-driver-tracking');
        }

        if (!empty($cityAdminRole)) {
            $cityAdminRole->givePermissionTo('view-driver-tracking');
        }
    }

    //
    public function createExtensionRoutes()
    {

        $filePath = base_path('routes/driver_tracking_extension.php');
        $fileExist = file_exists($filePath);
        if ($fileExist) {
            unlink($filePath);
        }
        //create the file afresh and write the content from the copyPath below
        $copyPath = __DIR__ . '/driver_tracking_extension.php';
        
        // Check if source file exists before attempting to copy
        if (!file_exists($copyPath)) {
            throw new \Exception("Extension route file not found at: " . $copyPath . ". Extension files may not have been copied properly.");
        }
        
        // Attempt to copy the file
        if (!copy($copyPath, $filePath)) {
            throw new \Exception("Failed to copy extension route file from " . $copyPath . " to " . $filePath);
        }
        
        // Verify the file was copied successfully
        if (!file_exists($filePath)) {
            throw new \Exception("Extension route file was not created at: " . $filePath);
        }
        
        //then unlink the copyPath
        unlink($copyPath);



        //
        //adding to web routes
        $filePath = base_path('routes/web.php');
        $find = "//:DRIVERTRACKINGEXTENSION";
        $replace = <<<'EOD'

        //:DRIVERTRACKINGEXTENSION
        require_once 'driver_tracking_extension.php';

        EOD;
        $found = $this->fileContains($find, $filePath);
        if (!$found) {
            //append to web.php file
            file_put_contents($filePath, $replace, FILE_APPEND);
        }



        // $extensionRoutePath = base_path('routes/extension.php');
        // //
        // $extensionRoutesExist = file_exists($extensionRoutePath);
        // if (!$extensionRoutesExist) {
        //     $replaceContent = <<<'EOD'
        //      <?php

        //      //imports
        //      use App\Http\Livewire\Extensions\DriverLiveTracking\DriverLiveTrackingExtension;

        //      Route::prefix('extensions')->group(function () {

        //          Route::group(['middleware' => ['auth']], function () {
        //              Route::get('driver/tracking', DriverLiveTrackingExtension::class)->name('driver.tracking');
        //          });
        //          //last route

        //      });
        //      EOD;

        //     $extensionRouteFile = fopen($extensionRoutePath, "w") or die("Unable to open file!");
        //     fwrite($extensionRouteFile, $replaceContent);
        //     fclose($extensionRouteFile);


        //     //adding the extension to routeservice provider
        //     $replaceContent = <<<'EOD'
        //      ->group(base_path('routes/web.php'));

        //      //
        //      Route::middleware('web')
        //          ->namespace($this->namespace)
        //          ->group(base_path('routes/extension.php'));


        //      EOD;
        //     //
        //     $routeServiceProviderPath = app_path('Providers/RouteServiceProvider.php');
        //     $contentSearched = "->group(base_path('routes/web.php'));";
        //     $this->replaceContent($contentSearched, $replaceContent, $routeServiceProviderPath);


        //     //
        // }

        // $extensionRoutePath = base_path('routes/extension.php');
        // //check if extension route file has needed routes
        // $routeFound = $this->fileContains("driver.tracking", $extensionRoutePath);
        // if ($routeFound) {

        //     //delete any line with: DriverLiveTrackingExtension
        //     $fileContent = file_get_contents($extensionRoutePath);
        //     $find = "DriverLiveTrackingExtension";
        //     $lines = explode("\n", $fileContent);
        //     $newLines = [];
        //     foreach ($lines as $line) {
        //         if (strpos($line, $find) === false) {
        //             $newLines[] = $line;
        //         }
        //     }
        //     $newContent = implode("\n", $newLines);
        //     file_put_contents($extensionRoutePath, $newContent);
        // }
    }

    //
    public function replaceContent($oldText, $newText, $filePath)
    {
        file_put_contents($filePath, str_replace($oldText, $newText, file_get_contents($filePath)));
    }

    public function fileContains($text, $filePath)
    {
        $fileContent = file_get_contents($filePath);
        return strpos($fileContent, $text);
    }
}
