<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourseGrade;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::get();
    }

    public function store(Request $request)
    {
        $student = new Student();
        $student->name = $request->name;
        $student->save();

        return response(200);
    }

    public function show($id)
    {
        return Student::whereId($id)->first();
    }

    public function edit(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $student->name = $request->name;
        $student->save();

        return response(200);
    }

    public function destroy(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $student->courses()->detach();
        $student->delete();

        return response(200);
    }

    public function students_classes(Request $request)
    {
        return Student::find($request->id)->courses()->get();
    }

    public function students_classes_unassigned(Request $request)
    {

        $all_courses = Course::all();
        $students_courses = Student::find($request->id)->courses()->get();

        $not_students_courses = [];

        foreach ($all_courses as $course) {
            if (!$students_courses->contains($course)) {
                array_push($not_students_courses, $course);
            }
        }

        return  $not_students_courses;
    }

    public function assign(Request $request)
    {
        Student::find($request->id)->courses()->attach($request->assign_id);

        return response(200);
    }

    public function unassign(Request $request)
    {
        Student::find($request->id)->courses()->detach($request->unassign_id);

        return response(200);
    }

    public function grade(Request $request)
    {
        $grade = StudentCourseGrade::where("student_id", $request->student_id)->where("course_id", $request->course_id)->first();
        $grade->grade_id = $request->grade_id;
        $grade->save();
        // Student::find($request->student_id)->courses()->attach($request->course_id, ['grade_id' => $request->grade_id]);
    }
}
