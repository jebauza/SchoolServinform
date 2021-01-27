<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['name'];

    // Relations
    public function students()
    {
        return $this->belongsToMany(Student::class, 'courses_students', 'course_id', 'student_id')
                    ->withTimestamps();
    }
}
