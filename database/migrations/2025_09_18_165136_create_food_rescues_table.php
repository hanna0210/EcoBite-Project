<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodRescuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_rescues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('original_price', 10, 2);
            $table->decimal('rescue_price', 10, 2);
            $table->integer('available_quantity')->default(1);
            $table->integer('total_quantity')->default(1);
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_until')->nullable();
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->text('pickup_instructions')->nullable();
            $table->json('tags')->nullable(); // For categories like "Bakery", "Fresh Produce", etc.
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['vendor_id', 'is_active']);
            $table->index(['available_from', 'available_until']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_rescues');
    }
}
