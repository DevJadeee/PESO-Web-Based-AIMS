<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number',
        'applicant_id',
        'program_id',
        'purpose_or_position',
        'place_or_agency',
        'time_in',
        'status',
        'submission_date',
        'remarks',
        'custom_fields',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'custom_fields' => 'array',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(EmploymentProgram::class, 'program_id');
    }

    public function scopeFilterByProgramCode($query, $code)
    {
        if (!$code) return $query;
        return $query->whereHas('program', function ($q) use ($code) {
            $q->where('code', strtoupper($code));
        });
    }

    public function scopeSearch($query, $term)
    {
        if (!$term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('application_number', 'like', "%{$term}%")
              ->orWhere('purpose_or_position', 'like', "%{$term}%")
              ->orWhere('place_or_agency', 'like', "%{$term}%")
              ->orWhere('status', 'like', "%{$term}%")
              ->orWhereHas('applicant', function ($aq) use ($term) {
                  $aq->where('first_name', 'like', "%{$term}%")
                     ->orWhere('last_name', 'like', "%{$term}%")
                     ->orWhere('contact_number', 'like', "%{$term}%")
                     ->orWhere('applicant_code', 'like', "%{$term}%");
              });
        });
    }
}
