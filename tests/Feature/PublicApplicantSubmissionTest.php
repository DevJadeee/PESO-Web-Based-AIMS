<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use App\Models\Barangay;
use App\Models\CityMunicipality;
use App\Models\EmploymentProgram;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicApplicantSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_application_submission_persists_applicant_and_application(): void
    {
        $this->seed(DatabaseSeeder::class);

        $program = EmploymentProgram::firstOrFail();
        $region = Region::firstOrFail();
        $province = Province::where('region_id', $region->id)->firstOrFail();
        $city = CityMunicipality::where('province_id', $province->id)->firstOrFail();
        $barangay = Barangay::where('city_municipality_id', $city->id)->firstOrFail();

        $response = $this->post(route('public.register.store'), [
            'program_id' => $program->id,
            'purpose_or_position' => 'Administrative Support',
            'place_or_agency' => 'Municipal Hall',
            'first_name' => 'Test',
            'middle_name' => 'Sample',
            'last_name' => 'Applicant',
            'suffix' => '',
            'birth_date' => '2000-01-15',
            'place_of_birth' => 'Bauang, La Union',
            'gender' => 'Male',
            'civil_status' => 'Single',
            'citizenship' => 'Filipino',
            'religion' => 'Roman Catholic',
            'tin' => '123-456-789',
            'contact_number' => '09171234567',
            'email' => 'test@example.com',
            'social_media_account' => 'facebook.com/test',
            'present_country' => 'Philippines',
            'present_region' => $region->id,
            'present_province' => $province->id,
            'present_city_municipality' => $city->id,
            'present_barangay' => $barangay->id,
            'present_street' => '123 Test Street',
            'same_as_present_address' => '1',
            'consent_certified' => '1',
            'data_privacy_consent' => '1',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('applicants', [
            'first_name' => 'Test',
            'last_name' => 'Applicant',
            'contact_number' => '09171234567',
        ]);

        $this->assertDatabaseHas('applications', [
            'purpose_or_position' => 'Administrative Support',
        ]);
    }

    public function test_failed_submission_keeps_address_values_and_same_as_present_state(): void
    {
        $this->seed(DatabaseSeeder::class);

        $program = EmploymentProgram::firstOrFail();
        $region = Region::firstOrFail();
        $province = Province::where('region_id', $region->id)->firstOrFail();
        $city = CityMunicipality::where('province_id', $province->id)->firstOrFail();
        $barangay = Barangay::where('city_municipality_id', $city->id)->firstOrFail();

        $response = $this->from(route('public.register'))->post(route('public.register.store'), [
            'program_id' => $program->id,
            'purpose_or_position' => '',
            'first_name' => 'Retain',
            'last_name' => 'Applicant',
            'birth_date' => '2000-01-15',
            'gender' => 'Male',
            'civil_status' => 'Single',
            'contact_number' => '09171234567',
            'present_country' => 'Philippines',
            'present_region' => $region->id,
            'present_province' => $province->id,
            'present_city_municipality' => $city->id,
            'present_barangay' => $barangay->id,
            'present_street' => '123 Test Street',
            'same_as_present_address' => '1',
            'consent_certified' => '1',
            'data_privacy_consent' => '1',
        ]);

        $response->assertRedirect(route('public.register'));

        $page = $this->get(route('public.register'));
        $page->assertSee('Retain', false);
        $page->assertSee('123 Test Street', false);
        $page->assertSee('same_as_present_address', false);
    }

    public function test_non_gip_program_allows_submission_without_purpose_or_position(): void
    {
        $this->seed(DatabaseSeeder::class);

        $program = EmploymentProgram::where('code', 'SPES')->firstOrFail();
        $region = Region::firstOrFail();
        $province = Province::where('region_id', $region->id)->firstOrFail();
        $city = CityMunicipality::where('province_id', $province->id)->firstOrFail();
        $barangay = Barangay::where('city_municipality_id', $city->id)->firstOrFail();

        $response = $this->post(route('public.register.store'), [
            'program_id' => $program->id,
            'first_name' => 'NonGip',
            'last_name' => 'Applicant',
            'birth_date' => '2000-02-20',
            'gender' => 'Female',
            'civil_status' => 'Single',
            'contact_number' => '09181234567',
            'present_country' => 'Philippines',
            'present_region' => $region->id,
            'present_province' => $province->id,
            'present_city_municipality' => $city->id,
            'present_barangay' => $barangay->id,
            'present_street' => '456 Sample Road',
            'same_as_present_address' => '1',
            'consent_certified' => '1',
            'data_privacy_consent' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('applicants', [
            'first_name' => 'NonGip',
            'last_name' => 'Applicant',
        ]);
    }
}
