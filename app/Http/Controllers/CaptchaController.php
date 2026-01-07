<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function simpleCaptcha(Request $request)
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $result = $num1 + $num2;

        // Store in session
        $request->session()->put('captcha_result', $result);
        $request->session()->save();

        return response()->json([
            'question' => $num1 . ' + ' . $num2 . ' = ?',
            'num1' => $num1,
            'num2' => $num2
        ]);
    }

    public function generateNewCaptcha(Request $request)
    {
        return $this->simpleCaptcha($request);
    }

    public function validateCaptcha($value)
    {
        $expected = Session::get('captcha_result');
        return $expected && (int)$value === (int)$expected;
    }
}
