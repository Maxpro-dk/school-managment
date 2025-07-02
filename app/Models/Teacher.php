<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'diploma',
        'address',
        'birth_date',
    ];

    // Relationships
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

} 