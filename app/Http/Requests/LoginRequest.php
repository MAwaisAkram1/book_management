<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // rules to validate against the request
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ];
    }

    // function to handle the validation error the user provider data in request send error message
    public function failedValidation(Validator $validator) {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([
            'message' => "invalid Credentials",
            'errors' => $errors,
        ], 401));
    }
}
