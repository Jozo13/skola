<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function grade()
    {
        return $this->belongsToMany(Course::class, 'student_course_grade')->withPivot('grade_id');
    }
}
