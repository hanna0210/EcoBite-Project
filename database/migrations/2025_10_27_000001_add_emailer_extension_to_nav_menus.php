<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NavMenu;

class AddEmailerExtensionToNavMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('nav_menus')) {
            // Check if the emailer extension nav menu already exists
            $navMenu = NavMenu::where('route', 'emailer.extension')->first();
            if (empty($navMenu)) {
                \DB::table('nav_menus')->insert(array(
                    0 =>
                    array(
                        'name' => 'Emailer',
                        'route' => 'emailer.extension',
                        'roles' => 'admin|city-admin',
                        'permissions' => "",
                        'icon' => 'heroicon-o-mail',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ),
                ));
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('nav_menus')) {
            NavMenu::where('route', 'emailer.extension')->delete();
        }
    }
}

