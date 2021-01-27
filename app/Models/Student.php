<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = ['name', 'surnames'];

    // Relations
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_students', 'student_id', 'course_id')
                    ->withTimestamps();
    }
}
