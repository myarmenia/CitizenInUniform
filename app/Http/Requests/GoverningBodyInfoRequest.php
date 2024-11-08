<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoverningBodyInfoRequest extends FormRequest
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

        $data = [];

        if ($this['type'] == 'email') {
            $data['text'] = 'required';
        }

        if ($this['type'] == 'phone') {
            $data['data.*.phone'] = 'required';
        }
// dd( $data);
        return $data;
    }
}
