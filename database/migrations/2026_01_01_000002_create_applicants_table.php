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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('applicant_code')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('barangay')->nullable();
            $table->text('address')->nullable();
            $table->string('educational_attainment')->nullable();
            $table->string('course_or_major')->nullable();
            $table->text('skills')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
