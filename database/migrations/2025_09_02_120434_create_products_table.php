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
       Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Product name
            $table->text('description')->nullable(); // Details about the product
            $table->decimal('price', 10, 2); // Price
            $table->unsignedBigInteger('category_id')->nullable(); // FK to categories
            $table->unsignedBigInteger('store_id')->nullable(); // FK to brands
            $table->string('image')->nullable(); // Main product image
            $table->boolean('status')->default(true); // Active/Inactive
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
