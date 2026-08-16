<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $existingRows = DB::table('applications')->get()->map(fn ($row) => (array) $row)->all();

            Schema::dropIfExists('applications');

            Schema::create('applications', function (Blueprint $table) {
                $table->id();
                $table->string('application_number')->unique();
                $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
                $table->foreignId('program_id')->constrained('employment_programs')->onDelete('cascade');
                $table->string('purpose_or_position')->nullable();
                $table->string('place_or_agency')->nullable();
                $table->string('time_in')->nullable();
                $table->string('status')->default('Pending');
                $table->date('submission_date');
                $table->text('remarks')->nullable();
                $table->json('custom_fields')->nullable();
                $table->timestamps();
            });

            foreach ($existingRows as $row) {
                DB::table('applications')->insert($row);
            }

            return;
        }

        Schema::table('applications', function (Blueprint $table) {
            $table->string('purpose_or_position')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
            DB::statement('DROP INDEX IF EXISTS applications_application_number_unique;');
            DB::statement('DROP TABLE IF EXISTS applications_old;');
            DB::statement('ALTER TABLE applications RENAME TO applications_old;');

            Schema::create('applications', function (Blueprint $table) {
                $table->id();
                $table->string('application_number')->unique();
                $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
                $table->foreignId('program_id')->constrained('employment_programs')->onDelete('cascade');
                $table->string('purpose_or_position');
                $table->string('place_or_agency')->nullable();
                $table->string('time_in')->nullable();
                $table->string('status')->default('Pending');
                $table->date('submission_date');
                $table->text('remarks')->nullable();
                $table->json('custom_fields')->nullable();
                $table->timestamps();
            });

            DB::statement('INSERT INTO applications (id, application_number, applicant_id, program_id, purpose_or_position, place_or_agency, time_in, status, submission_date, remarks, custom_fields, created_at, updated_at)
                SELECT id, application_number, applicant_id, program_id, purpose_or_position, place_or_agency, time_in, status, submission_date, remarks, custom_fields, created_at, updated_at
                FROM applications_old;');

            DB::statement('DROP TABLE applications_old;');
            DB::statement('PRAGMA foreign_keys = ON;');

            return;
        }

        Schema::table('applications', function (Blueprint $table) {
            $table->string('purpose_or_position')->nullable(false)->change();
        });
    }
};
