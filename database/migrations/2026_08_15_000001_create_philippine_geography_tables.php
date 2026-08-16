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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('country')->default('Philippines');
            $table->timestamps();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('cities_municipalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('province_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });

        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_municipality_id')->constrained('cities_municipalities')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangays');
        Schema::dropIfExists('cities_municipalities');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('regions');
    }
};
