<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Password;

class RegisterPostRequest extends FormRequest {



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' =>
                'required|string',

        ];
    }
}
