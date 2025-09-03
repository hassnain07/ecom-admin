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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name', 100);
            $table->string('description', 500)->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();

            // Owner info
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');

            // Contact info
            $table->string('contact_phone')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_postal_code')->nullable();

            // Policies
            $table->text('shipping_policy')->nullable();
            $table->text('return_policy')->nullable();
            $table->text('privacy_policy')->nullable();

            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
