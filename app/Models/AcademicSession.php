<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    use HasFactory;

    protected $table = 'academic_sessions';

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class, 'academic_session_id');
    }

    public function semesters()
    {
        return $this->hasManyThrough(Semester::class, Department::class);
    }
} 