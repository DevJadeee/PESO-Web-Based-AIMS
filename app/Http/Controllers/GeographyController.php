<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Province;
use App\Models\CityMunicipality;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GeographyController extends Controller
{
    public function regions(Request $request)
    {
        $country = $request->query('country');

        if ($country !== 'Philippines') {
            return response()->json([]);
        }

        $regions = Region::orderBy('name')->get(['id', 'name', 'code']);

        return response()->json($regions);
    }

    public function provinces(Request $request)
    {
        $regionId = $request->query('region_id');

        if (!$regionId) {
            return response()->json([]);
        }

        $provinces = Province::where('region_id', $regionId)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return response()->json($provinces);
    }

    public function citiesMunicipalities(Request $request)
    {
        $provinceId = $request->query('province_id');
        $regionId = $request->query('region_id');

        if ($provinceId) {
            $cities = CityMunicipality::where('province_id', $provinceId)
                ->orderBy('name')
                ->get(['id', 'name', 'code', 'type']);

            return response()->json($cities);
        }

        if ($regionId) {
            $cities = CityMunicipality::where('region_id', $regionId)
                ->whereNull('province_id')
                ->orderBy('name')
                ->get(['id', 'name', 'code', 'type']);

            return response()->json($cities);
        }

        return response()->json([]);
    }

    public function barangays(Request $request)
    {
        $cityMunicipalityId = $request->query('city_municipality_id');

        if (!$cityMunicipalityId) {
            return response()->json([]);
        }

        $barangays = Barangay::where('city_municipality_id', $cityMunicipalityId)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return response()->json($barangays);
    }

    public function loadPhilippinesData()
    {
        abort(404, 'Local geography dataset is bundled with the application and no external import endpoint is available.');
    }
}
