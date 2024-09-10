<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BmiHistoryRequest extends FormRequest
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
            'beneficiary_id'=>'integer',
            'weight'=>'required|string|nullable',
            'height'=>'required|string|nullable',
            'bmi'=>'required|string|nullable',
            'nutritional_status'=>'required|string|nullable',
            'bmi_date'=>'required|string|nullable', 
        ];
    }
}
