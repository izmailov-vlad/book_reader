<?php

namespace App\Http\Requests\User\GoogleAuth;

use Illuminate\Foundation\Http\FormRequest;

class LoginGoogleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string',
            'name' => 'string',
            'email' => 'required|string',
            'accessToken' => 'required|string',
        ];
    }
}
