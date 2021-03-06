<?php
namespace Domain\Student\Models;



use Domain\Course\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = ['name', 'surnames'];

    protected $appends = ['fullName'];

    //Attributes
    function getFullNameAttribute()
    {
        return $this->name .' '. $this->surnames;
    }

    // Scopes
    public function scopeName($query, $name)
    {
        if($name){
            return $query->where('name', 'like', "%$name%")
                            ->orWhere('surnames', 'like', "%$name%");
        }
    }

    public function scopeCourseId($query, $course = null)
    {
        if($course){
            return $query->whereHas('courses', function (Builder $query) use($course){
                $query->where('courses.id', $course);
            });
        }
    }

    public function scopeCourseName($query, $course = null)
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
