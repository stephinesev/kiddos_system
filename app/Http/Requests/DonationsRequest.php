<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationsRequest extends FormRequest
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
            'donor_id'=>'string|nullable',
            'event_id'=>'integer|nullable',
            'when_date'=>'required|string|nullable',
            'when_time'=>'required|string|nullable',
            'event_address'=>'required|string',
            'barangay'=>'required|integer',
            'donation_type'=>'required|string|nullable',
            'mode_of_collection'=>'required|string|nullable',
            'pickup_description'=>'string|nullable',
            'pickup_contact_no'=>'string|nullable',
            'others'=>'string|nullable',
        ];
    }
}
