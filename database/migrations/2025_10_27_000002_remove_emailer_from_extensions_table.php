<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEmailerFromExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove Emailer from extensions table as it's now only in nav_menus (left sidebar)
        // This makes it consistent with Driver Tracking extension behavior
        if (Schema::hasTable('extensions')) {
            \DB::table('extensions')->where('action', 'showEmailerView')->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Restore Emailer to extensions table if rolling back
        if (Schema::hasTable('extensions')) {
            $emailer = \DB::table('extensions')->where('action', 'showEmailerView')->first();
            if (empty($emailer)) {
                \DB::table('extensions')->insert(array(
                    0 =>
                    array(
                        'name' => 'Emailer',
                        'description' => 'Send emails to your customers',
                        'action' => 'showEmailerView',
                        'icon' => 'heroicon-o-mail',
                        'component' => 'extensions.emailer.emailer-extension',
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ),
                ));
            }
        }
    }
}

