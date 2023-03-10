<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return Course::get();
    }

    public function store(Request $request)
    {
        $course = new Course();
        $course->name = $request->name;
        $course->save();

        return response(200);
    }

    public function show($id)
    {
        return Course::whereId($id)->first();
    }

    public function edit(Request $request)
    {
        $course = Course::findOrFail($request->id);
        $course->name = $request->name;
        $course->save();

        return response(200);
    }

    public function destroy(Request $request)
    {
        $course = Course::findOrFail($request->id);
        $course->students()->detach();
        $course->delete();

        return response(200);
    }

    public function classes_students(Request $request)
    {
        return Course::find($request->id)->students()->get();
    }

    public function classes_students_unassigned(Request $request)
    {

        $all_students = Student::all();
        $courses_students = Course::find($request->id)->students()->get();

        $not_courses_students = [];

        foreach ($all_students as $student) {
            if (!$courses_students->contains($student)) {
                array_push($not_courses_students, $student);
            }
        }

        return  $not_courses_students;
    }

    public function assign(Request $request)
    {
        Course::find($request->id)->students()->attach($request->assign_id);

        return response(200);
    }

    public function unassign(Request $request)
    {
        Course::find($request->id)->students()->detach($request->unassign_id);

        return response(200);
    }
}
