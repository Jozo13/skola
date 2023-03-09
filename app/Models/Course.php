<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_course_grade')->withPivot('grade_id');
    }
}
