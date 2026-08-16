<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmploymentProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'badge_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'program_id');
    }
}
