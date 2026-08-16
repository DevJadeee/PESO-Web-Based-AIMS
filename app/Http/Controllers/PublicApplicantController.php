<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Applicant;
use App\Models\EmploymentProgram;
use App\Models\Application;
use App\Models\ActivityLog;
use App\Models\Region;
use App\Models\Province;
use App\Models\CityMunicipality;
use App\Models\Barangay;
use Carbon\Carbon;

class PublicApplicantController extends Controller
{
    /**
     * Show Public Application Registration Form (QR Entry Point)
     */
    public function showForm(Request $request)
    {
        $programs = Schema::hasTable('employment_programs')
            ? EmploymentProgram::where('is_active', true)->get()
            : collect();

        $selectedProgramCode = strtoupper($request->query('program', 'JOB'));

        return view('public.register', compact('programs', 'selectedProgramCode'));
    }

    protected function validateAddressHierarchy(array $validated, string $prefix): void
    {
        $country = $validated[$prefix . '_country'] ?? 'Philippines';
        if ($country !== 'Philippines') {
            throw ValidationException::withMessages([
                $prefix . '_country' => ['Only Philippine addresses are accepted for this application.'],
            ]);
        }

        $regionId = $validated[$prefix . '_region'] ?? null;
        $provinceId = $validated[$prefix . '_province'] ?? null;
        $cityId = $validated[$prefix . '_city_municipality'] ?? null;
        $barangayId = $validated[$prefix . '_barangay'] ?? null;

        if ($regionId) {
            $region = Region::find($regionId);
            if (!$region) {
                throw ValidationException::withMessages([
                    $prefix . '_region' => ['Please select a valid region.'],
                ]);
            }
        }

        if ($provinceId) {
            $province = Province::find($provinceId);
            if (!$province || ($regionId && $province->region_id != $regionId)) {
                throw ValidationException::withMessages([
                    $prefix . '_province' => ['The selected province does not belong to the selected region.'],
                ]);
            }
        } elseif ($regionId) {
            $region = Region::find($regionId);
            if ($region && strtoupper($region->code ?? '') !== 'NCR' && $region->name !== 'National Capital Region') {
                throw ValidationException::withMessages([
                    $prefix . '_province' => ['Please select a valid province for this region.'],
                ]);
            }
        }

        if ($cityId) {
            $city = CityMunicipality::find($cityId);
            if (!$city || ($provinceId && $city->province_id != $provinceId)) {
                throw ValidationException::withMessages([
                    $prefix . '_city_municipality' => ['The selected city or municipality does not belong to the selected province.'],
                ]);
            }
        }

        if ($barangayId) {
            $barangay = Barangay::find($barangayId);
            if (!$barangay || ($cityId && $barangay->city_municipality_id != $cityId)) {
                throw ValidationException::withMessages([
                    $prefix . '_barangay' => ['The selected barangay does not belong to the selected city or municipality.'],
                ]);
            }
        }
    }

    /**
     * Handle Application Form Submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => ['required', 'exists:employment_programs,id'],
            'purpose_or_position' => ['nullable', 'string', 'max:255'],
            'place_or_agency' => ['nullable', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['required', 'date'],
            'place_of_birth' => ['nullable', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'civil_status' => ['required', 'string'],
            'citizenship' => ['nullable', 'string', 'max:255'],
            'religion' => ['nullable', 'string', 'max:255'],
            'tin' => ['nullable', 'string', 'max:50'],
            'contact_number' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'social_media_account' => ['nullable', 'string', 'max:255'],
            'present_country' => ['required', 'string', 'in:Philippines'],
            'present_region' => ['required', 'exists:regions,id'],
            'present_province' => ['nullable', 'exists:provinces,id'],
            'present_city_municipality' => ['required', 'exists:cities_municipalities,id'],
            'present_barangay' => ['required', 'exists:barangays,id'],
            'present_street' => ['required', 'string', 'max:255'],
            'same_as_present_address' => ['nullable', 'boolean'],
            'permanent_country' => ['nullable', 'string', 'in:Philippines'],
            'permanent_region' => ['nullable', 'exists:regions,id'],
            'permanent_province' => ['nullable', 'exists:provinces,id'],
            'permanent_city_municipality' => ['nullable', 'exists:cities_municipalities,id'],
            'permanent_barangay' => ['nullable', 'exists:barangays,id'],
            'permanent_street' => ['nullable', 'string', 'max:255'],
            'educational_attainment' => ['nullable', 'string', 'max:255'],
            'course_or_major' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'father_contact_number' => ['nullable', 'string', 'max:50'],
            'father_occupation' => ['nullable', 'string', 'max:255'],
            'mother_maiden_name' => ['nullable', 'string', 'max:255'],
            'mother_contact_number' => ['nullable', 'string', 'max:50'],
            'mother_occupation' => ['nullable', 'string', 'max:255'],
            'gsis_beneficiary' => ['nullable', 'string', 'max:255'],
            'relationship_to_beneficiary' => ['nullable', 'string', 'max:255'],
            'applicant_status' => ['nullable', 'string', 'max:255'],
            'disability_type' => ['nullable', 'string', 'max:255'],
            'pwd' => ['nullable', 'boolean'],
            'senior_citizen' => ['nullable', 'boolean'],
            'indigenous_people' => ['nullable', 'boolean'],
            'former_ofw' => ['nullable', 'boolean'],
            'ofw' => ['nullable', 'boolean'],
            'four_ps_beneficiary' => ['nullable', 'boolean'],
            'household_id' => ['nullable', 'string', 'max:255'],
            'employment_status' => ['nullable', 'string', 'max:255'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'consent_certified' => ['required', 'boolean'],
            'data_privacy_consent' => ['required', 'boolean'],
        ]);

        $program = EmploymentProgram::find($validated['program_id'] ?? null);
        $purposeOrPosition = $validated['purpose_or_position'] ?? null;

        if ($program && strtoupper($program->code ?? '') === 'GIP') {
            $purpose = trim((string) ($purposeOrPosition ?? ''));
            if ($purpose === '') {
                throw ValidationException::withMessages([
                    'purpose_or_position' => ['Purpose or position requested is required for GIP applications.'],
                ]);
            }
        }

        $this->validateAddressHierarchy($validated, 'present');

        $sameAsPresent = (bool) ($validated['same_as_present_address'] ?? false);
        if ($sameAsPresent) {
            $validated['permanent_country'] = $validated['present_country'];
            $validated['permanent_region'] = $validated['present_region'];
            $validated['permanent_province'] = $validated['present_province'];
            $validated['permanent_city_municipality'] = $validated['present_city_municipality'];
            $validated['permanent_barangay'] = $validated['present_barangay'];
            $validated['permanent_street'] = $validated['present_street'];
        } else {
            $validated['permanent_country'] = $validated['permanent_country'] ?? 'Philippines';
            $validated['permanent_region'] = $validated['permanent_region'] ?? null;
            $validated['permanent_province'] = $validated['permanent_province'] ?? null;
            $validated['permanent_city_municipality'] = $validated['permanent_city_municipality'] ?? null;
            $validated['permanent_barangay'] = $validated['permanent_barangay'] ?? null;
            $validated['permanent_street'] = $validated['permanent_street'] ?? null;
            $this->validateAddressHierarchy($validated, 'permanent');
        }

        $validated['same_as_present_address'] = $sameAsPresent;
        $validated['pwd'] = (bool) ($validated['pwd'] ?? false);
        $validated['senior_citizen'] = (bool) ($validated['senior_citizen'] ?? false);
        $validated['indigenous_people'] = (bool) ($validated['indigenous_people'] ?? false);
        $validated['former_ofw'] = (bool) ($validated['former_ofw'] ?? false);
        $validated['ofw'] = (bool) ($validated['ofw'] ?? false);
        $validated['four_ps_beneficiary'] = (bool) ($validated['four_ps_beneficiary'] ?? false);
        $validated['consent_certified'] = (bool) ($validated['consent_certified'] ?? false);
        $validated['data_privacy_consent'] = (bool) ($validated['data_privacy_consent'] ?? false);

        $presentRegion = Region::find($validated['present_region'] ?? null);
        $presentProvince = Province::find($validated['present_province'] ?? null);
        $presentCity = CityMunicipality::find($validated['present_city_municipality'] ?? null);
        $presentBarangay = Barangay::find($validated['present_barangay'] ?? null);

        $permanentRegion = Region::find($validated['permanent_region'] ?? null);
        $permanentProvince = Province::find($validated['permanent_province'] ?? null);
        $permanentCity = CityMunicipality::find($validated['permanent_city_municipality'] ?? null);
        $permanentBarangay = Barangay::find($validated['permanent_barangay'] ?? null);

        $presentAddress = trim(implode(', ', array_filter([
            $validated['present_street'] ?? null,
            $presentBarangay?->name,
            $presentCity?->name,
            $presentProvince?->name,
            $presentRegion?->name,
            $validated['present_country'] ?? 'Philippines',
        ])));

        $permanentAddress = trim(implode(', ', array_filter([
            $validated['permanent_street'] ?? null,
            $permanentBarangay?->name,
            $permanentCity?->name,
            $permanentProvince?->name,
            $permanentRegion?->name,
            $validated['permanent_country'] ?? 'Philippines',
        ])));

        $applicant = Applicant::where('contact_number', $validated['contact_number'])
            ->where('first_name', $validated['first_name'])
            ->where('last_name', $validated['last_name'])
            ->first();

        if (!$applicant) {
            $count = Applicant::count() + 1;
            $applicantCode = 'PESO-AGOO-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $applicantData = array_merge($validated, [
                'applicant_code' => $applicantCode,
                'is_active' => true,
                'present_country' => $validated['present_country'],
                'present_region_id' => $validated['present_region'],
                'present_region_name' => $presentRegion?->name,
                'present_province_id' => $validated['present_province'],
                'present_province_name' => $presentProvince?->name,
                'present_city_municipality_id' => $validated['present_city_municipality'],
                'present_city_municipality_name' => $presentCity?->name,
                'present_barangay_id' => $validated['present_barangay'],
                'present_barangay_name' => $presentBarangay?->name,
                'present_street_address' => $validated['present_street'],
                'permanent_country' => $validated['same_as_present_address'] ? ($validated['present_country']) : ($validated['permanent_country'] ?? 'Philippines'),
                'permanent_region_id' => $validated['same_as_present_address'] ? ($validated['present_region']) : ($validated['permanent_region'] ?? null),
                'permanent_region_name' => $validated['same_as_present_address'] ? ($presentRegion?->name) : ($permanentRegion?->name),
                'permanent_province_id' => $validated['same_as_present_address'] ? ($validated['present_province']) : ($validated['permanent_province'] ?? null),
                'permanent_province_name' => $validated['same_as_present_address'] ? ($presentProvince?->name) : ($permanentProvince?->name),
                'permanent_city_municipality_id' => $validated['same_as_present_address'] ? ($validated['present_city_municipality']) : ($validated['permanent_city_municipality'] ?? null),
                'permanent_city_municipality_name' => $validated['same_as_present_address'] ? ($presentCity?->name) : ($permanentCity?->name),
                'permanent_barangay_id' => $validated['same_as_present_address'] ? ($validated['present_barangay']) : ($validated['permanent_barangay'] ?? null),
                'permanent_barangay_name' => $validated['same_as_present_address'] ? ($presentBarangay?->name) : ($permanentBarangay?->name),
                'permanent_street_address' => $validated['same_as_present_address'] ? ($validated['present_street']) : ($validated['permanent_street'] ?? null),
                'present_address' => $presentAddress,
                'permanent_address' => $validated['same_as_present_address'] ? $presentAddress : $permanentAddress,
                'address' => $presentAddress,
            ]);

            $applicant = Applicant::create($applicantData);
        } else {
            $applicant->update([
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'civil_status' => $validated['civil_status'],
                'citizenship' => $validated['citizenship'] ?? null,
                'religion' => $validated['religion'] ?? null,
                'tin' => $validated['tin'] ?? null,
                'email' => $validated['email'] ?? null,
                'social_media_account' => $validated['social_media_account'] ?? null,
                'present_country' => $validated['present_country'],
                'present_region_id' => $validated['present_region'],
                'present_region_name' => $presentRegion?->name,
                'present_province_id' => $validated['present_province'],
                'present_province_name' => $presentProvince?->name,
                'present_city_municipality_id' => $validated['present_city_municipality'],
                'present_city_municipality_name' => $presentCity?->name,
                'present_barangay_id' => $validated['present_barangay'],
                'present_barangay_name' => $presentBarangay?->name,
                'present_street_address' => $validated['present_street'],
                'permanent_country' => $validated['same_as_present_address'] ? ($validated['present_country']) : ($validated['permanent_country'] ?? 'Philippines'),
                'permanent_region_id' => $validated['same_as_present_address'] ? ($validated['present_region']) : ($validated['permanent_region'] ?? null),
                'permanent_region_name' => $validated['same_as_present_address'] ? ($presentRegion?->name) : ($permanentRegion?->name),
                'permanent_province_id' => $validated['same_as_present_address'] ? ($validated['present_province']) : ($validated['permanent_province'] ?? null),
                'permanent_province_name' => $validated['same_as_present_address'] ? ($presentProvince?->name) : ($permanentProvince?->name),
                'permanent_city_municipality_id' => $validated['same_as_present_address'] ? ($validated['present_city_municipality']) : ($validated['permanent_city_municipality'] ?? null),
                'permanent_city_municipality_name' => $validated['same_as_present_address'] ? ($presentCity?->name) : ($permanentCity?->name),
                'permanent_barangay_id' => $validated['same_as_present_address'] ? ($validated['present_barangay']) : ($validated['permanent_barangay'] ?? null),
                'permanent_barangay_name' => $validated['same_as_present_address'] ? ($presentBarangay?->name) : ($permanentBarangay?->name),
                'permanent_street_address' => $validated['same_as_present_address'] ? ($validated['present_street']) : ($validated['permanent_street'] ?? null),
                'present_address' => $presentAddress,
                'permanent_address' => $validated['same_as_present_address'] ? $presentAddress : $permanentAddress,
                'address' => $presentAddress,
                'same_as_present_address' => $validated['same_as_present_address'],
                'educational_attainment' => $validated['educational_attainment'],
                'course_or_major' => $validated['course_or_major'],
                'skills' => $validated['skills'],
                'father_name' => $validated['father_name'] ?? null,
                'father_contact_number' => $validated['father_contact_number'] ?? null,
                'father_occupation' => $validated['father_occupation'] ?? null,
                'mother_maiden_name' => $validated['mother_maiden_name'] ?? null,
                'mother_contact_number' => $validated['mother_contact_number'] ?? null,
                'mother_occupation' => $validated['mother_occupation'] ?? null,
                'gsis_beneficiary' => $validated['gsis_beneficiary'] ?? null,
                'relationship_to_beneficiary' => $validated['relationship_to_beneficiary'] ?? null,
                'applicant_status' => $validated['applicant_status'] ?? null,
                'disability_type' => $validated['disability_type'] ?? null,
                'pwd' => $validated['pwd'],
                'senior_citizen' => $validated['senior_citizen'],
                'indigenous_people' => $validated['indigenous_people'],
                'former_ofw' => $validated['former_ofw'],
                'ofw' => $validated['ofw'],
                'four_ps_beneficiary' => $validated['four_ps_beneficiary'],
                'household_id' => $validated['household_id'] ?? null,
                'employment_status' => $validated['employment_status'] ?? null,
                'photo_path' => $validated['photo_path'] ?? null,
                'consent_certified' => $validated['consent_certified'],
                'data_privacy_consent' => $validated['data_privacy_consent'],
            ]);
        }

        $program = EmploymentProgram::findOrFail($validated['program_id']);
        $appCount = Application::count() + 1;
        $appNumber = 'APP-' . $program->code . '-' . date('Y') . '-' . str_pad($appCount, 4, '0', STR_PAD_LEFT);

        $timeIn = Carbon::now('Asia/Manila')->format('h:i A');

        $programSpecificFields = collect($request->all())->except([
            '_token',
            'program_id',
            'purpose_or_position',
            'place_or_agency',
            'first_name',
            'middle_name',
            'last_name',
            'suffix',
            'birth_date',
            'place_of_birth',
            'gender',
            'civil_status',
            'citizenship',
            'religion',
            'tin',
            'contact_number',
            'email',
            'social_media_account',
            'barangay',
            'address',
            'present_address',
            'permanent_address',
            'same_as_present_address',
            'educational_attainment',
            'course_or_major',
            'skills',
            'father_name',
            'father_contact_number',
            'father_occupation',
            'mother_maiden_name',
            'mother_contact_number',
            'mother_occupation',
            'gsis_beneficiary',
            'relationship_to_beneficiary',
            'applicant_status',
            'disability_type',
            'pwd',
            'senior_citizen',
            'indigenous_people',
            'former_ofw',
            'ofw',
            'four_ps_beneficiary',
            'household_id',
            'employment_status',
            'photo_path',
            'consent_certified',
            'data_privacy_consent',
        ])->toArray();

        $application = Application::create([
            'application_number' => $appNumber,
            'applicant_id' => $applicant->id,
            'program_id' => $program->id,
            'purpose_or_position' => $purposeOrPosition,
            'place_or_agency' => $validated['place_or_agency'] ?? 'PESO Agoo Office',
            'time_in' => $timeIn,
            'status' => 'Pending',
            'submission_date' => Carbon::now()->toDateString(),
            'remarks' => 'Submitted via Public QR Code Portal.',
            'custom_fields' => $programSpecificFields,
        ]);

        ActivityLog::create([
            'user_id' => null,
            'action' => 'PUBLIC_APPLICATION_SUBMITTED',
            'description' => "Applicant {$applicant->full_name} submitted application {$appNumber} for program {$program->code}.",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('public.confirmation', $application->application_number)
            ->with('success', 'Application submitted successfully!');
    }

    /**
     * Show Submission Confirmation Page
     */
    public function confirmation($applicationNumber)
    {
        $application = Application::with('applicant', 'program')
            ->where('application_number', $applicationNumber)
            ->firstOrFail();

        return view('public.confirmation', compact('application'));
    }
}
