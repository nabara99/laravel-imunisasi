<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = DB::table('students')
        ->join('schools', 'students.id_school', '=', 'schools.id')
        ->select('students.*', 'schools.name')
        ->get();

        return view('pages.student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();

        return view('pages.student.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_student' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'nik' => 'required|unique:students,nik|min:16|max:16',
            'mother_name' => 'required',
            'mother_nik' => 'required',
            'id_school' => 'required',
            'class' => 'required',
        ]);

        Student::create($validated);

        return redirect()->route('child-sch.index')->with('success', 'Data anak berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $schools = School::all();
        $student = Student::findOrFail($id);
        return view('pages.student.edit', compact('schools', 'student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name_student' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'nik' => 'required|min:16|max:16',
            'mother_name' => 'required',
            'mother_nik' => 'required',
            'id_school' => 'required',
            'class' => 'required',
        ]);

        $student->update($validated);

        return redirect()->route('child-sch.index')->with('success', 'Data anak berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('child-sch.index')->with('success', 'Data anak berhasil dihapus');
    }
}
