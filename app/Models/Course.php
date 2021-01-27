<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['name'];

    // Scopes
    public function scopeName($query, $name)
    {
        if($name){
            return $query->where('name', 'like', "%$name%");
        }
    }

    public function scopeStudent($query, $student = null)
    {
        if($student){
            return $query->whereHas('students', function (Builder $query) use($student){
                $query->name($student);
            });
        }
    }

    // Relations
    public function students()
    {
        return $this->belongsToMany(Student::class, 'courses_students', 'course_id', 'student_id')
                    ->withTimestamps();
    }
}
