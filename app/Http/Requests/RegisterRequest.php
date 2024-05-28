<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ];
    }
    // function the user provider data is fails according the validation send error message.
    public function failedValidation(Validator $validator) {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([
            'message' => 'User not Created',
            'errors' => $errors,
        ], 401));
    }
}
