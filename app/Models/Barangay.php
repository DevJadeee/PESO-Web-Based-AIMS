<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = ['city_municipality_id', 'name', 'code'];

    public function cityMunicipality(): BelongsTo
    {
        return $this->belongsTo(CityMunicipality::class);
    }
}
