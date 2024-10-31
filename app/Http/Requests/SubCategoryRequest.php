<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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

        $data =  [
            'category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ];

        if(isset($this->files)){
            $data['files.*'] = 'required|file|max:5012';
        }

        return $data;
    }
}
