<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'captcha' => ['required', 'integer'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'captcha.required' => 'Captcha wajib diisi.',
            'captcha.integer' => 'Captcha harus berupa angka.',
        ];
    }

    /**
     * Validate captcha after basic validation passes
     * This method is called ONCE after form validation succeeds
     */
    protected function passedValidation(): void
    {
        $expected = Session::get('captcha_result');
        $provided = (int) $this->input('captcha');

        if (!$expected || $provided !== $expected) {
            throw ValidationException::withMessages([
                'captcha' => ['Jawaban captcha salah. Silakan refresh dan coba lagi.'],
            ]);
        }

        // Clear captcha after successful validation
        Session::forget('captcha_result');
    }
}
