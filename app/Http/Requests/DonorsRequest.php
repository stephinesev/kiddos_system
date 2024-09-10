<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonorsRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname'=>'required|string|nullable',
            'password'=>'required|string|nullable',
            'birth_date'=>'required|string|nullable',
            'gender'=>'required|string|nullable',
            'address'=>'required|string|nullable',
            'email' => 'required|email|nullable|unique:users,email,'.$this->id,
            'contact_no'=>'required|string|nullable',
        ];
    }
}
