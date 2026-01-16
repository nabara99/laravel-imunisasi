<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    public function index()
    {
        $vaccines = Vaccine::with('category')
            ->orderBy('vaccine_name')
            ->get();

        return view('pages.vaccines.index', compact('vaccines'));
    }
}
