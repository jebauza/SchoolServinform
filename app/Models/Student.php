<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = ['name', 'surnames'];

    // Scopes
    public function scopeName($query, $name)
    {
        if($name){
            return $query->where('name', 'like', "%$name%")
                            ->orWhere('surnames', 'like', "%$name%");
        }
    }

    public function scopeCourse($query, $course = null)
    {
        if($course){
            return $query->whereHas('courses', function (Builder $query) use($course){
                $query->name($course);
            });
        }
    }

    // Relations
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_students', 'student_id', 'course_id')
                    ->withTimestamps();
    }
}
