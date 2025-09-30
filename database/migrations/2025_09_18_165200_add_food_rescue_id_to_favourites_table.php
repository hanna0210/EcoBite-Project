<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFoodRescueIdToFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->foreignId('food_rescue_id')->nullable()->constrained()->onDelete('cascade');
            $table->index('food_rescue_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->dropForeign(['food_rescue_id']);
            $table->dropIndex(['food_rescue_id']);
            $table->dropColumn('food_rescue_id');
        });
    }
}
