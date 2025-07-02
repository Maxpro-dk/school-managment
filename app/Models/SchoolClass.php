<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;
    
    protected $table = 'school_classes';
    
    protected $fillable = [
        'name',
        'level',
        'academic_year',
        'teacher_id', // Foreign key for the class teacher
    ];

    // Relationships
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'school_class_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'school_class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }


} 