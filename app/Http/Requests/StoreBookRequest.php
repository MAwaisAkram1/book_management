<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|max:255|',
            'author' => 'required|max:255',
            'published_date' => 'required|date',
            'genre' => 'required|max:255',
            'price' => 'required|numeric',
        ];
    }

    // function to send the error if the validation failed.
    public function failedValidation(Validator $validator){
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([
           'message' => 'Validation Error',
           'error' => $errors,
        ], 401));
    }
}
