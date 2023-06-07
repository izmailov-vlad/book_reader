<?php

namespace App\Http\Requests\Book\Detail;

use Illuminate\Foundation\Http\FormRequest;

class BookDetailRateBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'rate' => 'required|integer',
            'book_id' => 'required|string',
        ];
    }
}
