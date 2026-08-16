<?php

namespace Tests\Feature;

use App\Models\Barangay;
use App\Models\CityMunicipality;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhilippineGeographyImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_local_philippine_dataset_seeds_pangasinan_and_valid_municipality_hierarchy(): void
    {
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder'])->assertSuccessful();

        $pangasinan = Province::where('name', 'Pangasinan')->firstOrFail();
        $municipalities = CityMunicipality::where('province_id', $pangasinan->id)->pluck('name');

        $this->assertTrue($municipalities->contains('City of Alaminos'));
        $this->assertTrue($municipalities->contains('City of Dagupan'));

        $municipality = CityMunicipality::where('province_id', $pangasinan->id)
            ->where('name', 'City of Dagupan')
            ->firstOrFail();

        $barangays = Barangay::where('city_municipality_id', $municipality->id)->pluck('name');

        $this->assertNotEmpty($barangays);
        $this->assertTrue($barangays->contains('Bonuan Boquig'));
        $this->assertTrue($barangays->contains('Mangin'));
        $this->assertTrue($barangays->contains('Poblacion Oeste'));

        $this->assertDatabaseHas('barangays', [
            'city_municipality_id' => $municipality->id,
            'name' => 'Bonuan Boquig',
        ]);
    }

    public function test_ncr_uses_city_municipality_hierarchy_without_provinces(): void
    {
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder'])->assertSuccessful();

        $ncr = Region::where('name', 'National Capital Region')->firstOrFail();
        $city = CityMunicipality::where('region_id', $ncr->id)
            ->where('name', 'Quezon City')
            ->firstOrFail();

        $this->assertNull($city->province_id);
        $this->assertGreaterThan(0, Barangay::where('city_municipality_id', $city->id)->count());
    }
}
