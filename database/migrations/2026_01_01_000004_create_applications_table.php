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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_number')->unique();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('employment_programs')->onDelete('cascade');
            $table->string('purpose_or_position');
            $table->string('place_or_agency')->nullable();
            $table->string('time_in')->nullable();
            $table->string('status')->default('Pending'); // Pending, Under Review, Approved, Completed, Rejected
            $table->date('submission_date');
            $table->text('remarks')->nullable();
            $table->json('custom_fields')->nullable(); // Extensible schema for future form fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
