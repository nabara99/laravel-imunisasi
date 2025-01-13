<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\StudentTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = DB::table('student_targets')
        ->join('schools', 'student_targets.id_school', '=', 'schools.id')
        ->select('student_targets.*', 'schools.name')
        ->get();

        return view('pages.student-target.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        return view('pages.student-target.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_school' => 'required',
            'classroom' => 'required',
            'sum_boys' => 'required|numeric',
            'sum_girls' => 'required|numeric',
        ]);

        StudentTarget::create($validated);

        return redirect()->route('student-target.index')->with('success', 'Data Sasaran berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentTarget $studentTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = StudentTarget::findOrFail($id);
        $schools = School::all();

        return view('pages.student-target.edit', compact('student', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = StudentTarget::findOrFail($id);

        $validated = $request->validate([
            'id_school' => 'required',
            'classroom' => 'required',
            'sum_boys' => 'required|numeric',
            'sum_girls' => 'required|numeric',
        ]);

        $student->update($validated);

        return redirect()->route('student-target.index')->with('success', 'Data Sasaran berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentTarget $studentTarget)
    {
        //
    }
}
