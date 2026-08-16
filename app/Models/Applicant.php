<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_code',
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
        'country',
        'region_id',
        'province_id',
        'city_municipality_id',
        'barangay_id',
        'street_address',
        'present_country',
        'present_region_id',
        'present_region_name',
        'present_province_id',
        'present_province_name',
        'present_city_municipality_id',
        'present_city_municipality_name',
        'present_barangay_id',
        'present_barangay_name',
        'present_street_address',
        'permanent_country',
        'permanent_region_id',
        'permanent_region_name',
        'permanent_province_id',
        'permanent_province_name',
        'permanent_city_municipality_id',
        'permanent_city_municipality_name',
        'permanent_barangay_id',
        'permanent_barangay_name',
        'permanent_street_address',
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
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the applications submitted by this applicant.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class)->orderBy('created_at', 'desc');
    }

    public function presentRegion()
    {
        return $this->belongsTo(Region::class, 'present_region_id');
    }

    public function presentProvince()
    {
        return $this->belongsTo(Province::class, 'present_province_id');
    }

    public function presentCityMunicipality()
    {
        return $this->belongsTo(CityMunicipality::class, 'present_city_municipality_id');
    }

    public function presentBarangay()
    {
        return $this->belongsTo(Barangay::class, 'present_barangay_id');
    }

    /**
     * Full Name Accessor
     */
    public function getFullNameAttribute(): string
    {
        $name = $this->first_name;
        if (!empty($this->middle_name)) {
            $name .= ' ' . substr($this->middle_name, 0, 1) . '.';
        }
        $name .= ' ' . $this->last_name;
        if (!empty($this->suffix)) {
            $name .= ' ' . $this->suffix;
        }
        return $name;
    }

    /**
     * Search Scope
     */
    public function scopeSearch($query, $term)
    {
        if (!$term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('applicant_code', 'like', "%{$term}%")
              ->orWhere('first_name', 'like', "%{$term}%")
              ->orWhere('middle_name', 'like', "%{$term}%")
              ->orWhere('last_name', 'like', "%{$term}%")
              ->orWhere('contact_number', 'like', "%{$term}%")
              ->orWhere('barangay', 'like', "%{$term}%")
              ->orWhere('educational_attainment', 'like', "%{$term}%");
        });
    }
}
