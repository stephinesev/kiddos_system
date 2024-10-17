<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventsRequest extends FormRequest
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
            'event_name'=>'required|string|nullable',
            'event_description'=>'string|nullable',
            'event_color'=>'required|string|nullable',
            'barangay'=>'required|integer',
            'event_address'=>'required|string|nullable',
            'event_time'=>'required|string|nullable',
            'start_date'=>'required|string|nullable',
            'end_date'=>'required|string|nullable',
        ];
    }
}
