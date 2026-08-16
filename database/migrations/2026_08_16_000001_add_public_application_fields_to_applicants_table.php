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
        Schema::table('applicants', function (Blueprint $table) {
            if (!Schema::hasColumn('applicants', 'place_of_birth')) {
                $table->string('place_of_birth')->nullable()->after('birth_date');
            }

            if (!Schema::hasColumn('applicants', 'citizenship')) {
                $table->string('citizenship')->nullable()->after('civil_status');
            }

            if (!Schema::hasColumn('applicants', 'religion')) {
                $table->string('religion')->nullable()->after('citizenship');
            }

            if (!Schema::hasColumn('applicants', 'tin')) {
                $table->string('tin')->nullable()->after('religion');
            }

            if (!Schema::hasColumn('applicants', 'email')) {
                $table->string('email')->nullable()->after('contact_number');
            }

            if (!Schema::hasColumn('applicants', 'social_media_account')) {
                $table->string('social_media_account')->nullable()->after('email');
            }

            if (!Schema::hasColumn('applicants', 'country')) {
                $table->string('country')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'region_id')) {
                $table->unsignedBigInteger('region_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'province_id')) {
                $table->unsignedBigInteger('province_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'city_municipality_id')) {
                $table->unsignedBigInteger('city_municipality_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'barangay_id')) {
                $table->unsignedBigInteger('barangay_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'street_address')) {
                $table->string('street_address')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_country')) {
                $table->string('present_country')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_region_id')) {
                $table->unsignedBigInteger('present_region_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_region_name')) {
                $table->string('present_region_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_province_id')) {
                $table->unsignedBigInteger('present_province_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_province_name')) {
                $table->string('present_province_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_city_municipality_id')) {
                $table->unsignedBigInteger('present_city_municipality_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_city_municipality_name')) {
                $table->string('present_city_municipality_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_barangay_id')) {
                $table->unsignedBigInteger('present_barangay_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_barangay_name')) {
                $table->string('present_barangay_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_street_address')) {
                $table->string('present_street_address')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_country')) {
                $table->string('permanent_country')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_region_id')) {
                $table->unsignedBigInteger('permanent_region_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_region_name')) {
                $table->string('permanent_region_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_province_id')) {
                $table->unsignedBigInteger('permanent_province_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_province_name')) {
                $table->string('permanent_province_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_city_municipality_id')) {
                $table->unsignedBigInteger('permanent_city_municipality_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_city_municipality_name')) {
                $table->string('permanent_city_municipality_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_barangay_id')) {
                $table->unsignedBigInteger('permanent_barangay_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_barangay_name')) {
                $table->string('permanent_barangay_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_street_address')) {
                $table->string('permanent_street_address')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'present_address')) {
                $table->text('present_address')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'permanent_address')) {
                $table->text('permanent_address')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'same_as_present_address')) {
                $table->boolean('same_as_present_address')->default(false);
            }

            if (!Schema::hasColumn('applicants', 'father_name')) {
                $table->string('father_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'father_contact_number')) {
                $table->string('father_contact_number')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'father_occupation')) {
                $table->string('father_occupation')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'mother_maiden_name')) {
                $table->string('mother_maiden_name')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'mother_contact_number')) {
                $table->string('mother_contact_number')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'mother_occupation')) {
                $table->string('mother_occupation')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'gsis_beneficiary')) {
                $table->string('gsis_beneficiary')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'relationship_to_beneficiary')) {
                $table->string('relationship_to_beneficiary')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'applicant_status')) {
                $table->string('applicant_status')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'disability_type')) {
                $table->string('disability_type')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'pwd')) {
                $table->boolean('pwd')->default(false);
            }

            if (!Schema::hasColumn('applicants', 'senior_citizen')) {
                $table->boolean('senior_citizen')->default(false);
            }

            if (!Schema::hasColumn('applicants', 'indigenous_people')) {
                $table->boolean('indigenous_people')->default(false);
            }

            if (!Schema::hasColumn('applicants', 'former_ofw')) {
                $table->boolean('former_ofw')->default(false);
            }

            if (!Schema::hasColumn('applicants', 'ofw')) {
                $table->boolean('ofw')->default(false);
            }

            if (!Schema::hasColumn('applicants', 'four_ps_beneficiary')) {
                $table->boolean('four_ps_beneficiary')->default(false);
            }

            if (!Schema::hasColumn('applicants', 'household_id')) {
                $table->string('household_id')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'employment_status')) {
                $table->string('employment_status')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'photo_path')) {
                $table->string('photo_path')->nullable();
            }

            if (!Schema::hasColumn('applicants', 'consent_certified')) {
                $table->boolean('consent_certified')->default(false);
            }

            if (!Schema::hasColumn('applicants', 'data_privacy_consent')) {
                $table->boolean('data_privacy_consent')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $columns = [
                'place_of_birth','citizenship','religion','tin','email','social_media_account','country','region_id','province_id','city_municipality_id','barangay_id','street_address','present_country','present_region_id','present_region_name','present_province_id','present_province_name','present_city_municipality_id','present_city_municipality_name','present_barangay_id','present_barangay_name','present_street_address','permanent_country','permanent_region_id','permanent_region_name','permanent_province_id','permanent_province_name','permanent_city_municipality_id','permanent_city_municipality_name','permanent_barangay_id','permanent_barangay_name','permanent_street_address','present_address','permanent_address','same_as_present_address','father_name','father_contact_number','father_occupation','mother_maiden_name','mother_contact_number','mother_occupation','gsis_beneficiary','relationship_to_beneficiary','applicant_status','disability_type','pwd','senior_citizen','indigenous_people','former_ofw','ofw','four_ps_beneficiary','household_id','employment_status','photo_path','consent_certified','data_privacy_consent'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('applicants', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
