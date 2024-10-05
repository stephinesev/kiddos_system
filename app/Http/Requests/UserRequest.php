<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username'=>'string|nullable|unique:users,username,'.$this->id,
            'name'=>'required|string|nullable',
            'password'=>'sometimes|required|string|nullable',
            'birth_date'=>'required|string|nullable',
            'gender'=>'required|string|nullable',
            'address'=>'required|string|nullable',
            'status'=>'required|string|nullable',
            'email' => 'required|email|nullable|unique:users,email,'.$this->id,
            'weight' => 'string|nullable',
            'height' => 'string|nullable',
            'bmi' => 'string|nullable',
            'barangay' => 'string|nullable',
            'school_name' => 'string|nullable',
            'grade_level' => 'string|nullable',
            'student_id' => 'string|nullable',
            'guardian_name' => 'string|nullable',
            'guardian_contact_no' => 'string|nullable',
            'guardian_relationship' => 'string|nullable',
            'nutritional_status' => 'string|nullable',
        ];
    }
}
