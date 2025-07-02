<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'registration_number',
        'school_class_id', // Changed from class_id to school_class_id for clarity
        'tutor_name',
        'tutor_phone',
        'tutor_email',
        'address',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relationships
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
} 