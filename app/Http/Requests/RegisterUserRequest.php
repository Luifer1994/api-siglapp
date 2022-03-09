<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'type_document' => 'required|integer|exists:type_documents,id',
            'type_user'     => 'required|integer|exists:type_users,id',
            'document'      => 'required|integer|unique:users,document',
            'center_op'     => 'required',
            'seller'        => 'required',
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users,email',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}