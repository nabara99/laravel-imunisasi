<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentImun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentImunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = DB::table('student_imuns')
        ->join('students', 'student_imuns.id_student', '=', 'students.id')
        ->join('schools', 'students.id_school', '=', 'schools.id')
        ->select('student_imuns.*', 'students.name_student', 'students.nik', 'students.gender', 'students.class', 'schools.name')
        ->get();

        return view('pages.bias.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('pages.bias.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_student' => 'required|unique:student_imuns,id_student',
        ], [
            'id_student.unique' => 'Data anak sudah ada'
        ]);

        StudentImun::create([
            'id_student' => $request->id_student,
            'dt' => $request->dt,
            'mr' => $request->mr,
            'td1' => $request->td1,
            'td2pa' => $request->td2pa,
            'td2pi' => $request->td2pi,
            'hpv1' => $request->hpv1,
            'hpv2' => $request->hpv2,
        ]);

        return redirect()->route('bias.index')->with('success', 'Data BIAS berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentImun $studentImum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bias = StudentImun::findOrFail($id);
        $students = Student::all();

        return view('pages.bias.edit', compact('bias', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bias = StudentImun::findOrFail($id);

        $bias->update([
            'id_student' => $request->id_student,
            'dt' => $request->dt,
            'mr' => $request->mr,
            'td1' => $request->td1,
            'td2pa' => $request->td2pa,
            'td2pi' => $request->td2pi,
            'hpv1' => $request->hpv1,
            'hpv2' => $request->hpv2,
        ]);

        return redirect()->route('bias.index')->with('success', 'Data BIAS berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentImun $studentImum)
    {
        //
    }
}
