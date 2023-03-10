<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        return Grade::get();
    }

    public function store(Request $request)
    {
        $student = new Grade();
        $student->name = $request->name;
        $student->value = $request->value;
        $student->save();

        return response(200);
    }

    public function show($id)
    {
        return Grade::whereId($id)->first();
    }

    public function edit(Request $request)
    {
        $student = Grade::findOrFail($request->id);
        $student->name = $request->name;
        $student->value = $request->value;
        $student->save();

        return response(200);
    }

    public function destroy(Request $request)
    {
        $student = Grade::findOrFail($request->id);
        $student->delete();

        return response(200);
    }
}
