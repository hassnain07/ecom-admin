<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_charges', function (Blueprint $table) {
            $table->id();            
            $table->decimal('charges', 10, 2)->default(0)->comment('Delivery charges for the store');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')
                  ->references('id')
                  ->on('stores')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_charges');
    }
};
