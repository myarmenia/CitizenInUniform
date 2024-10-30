<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqCategorySubcategoryRequest extends FormRequest
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
           'f_a_q_category_id'=>'required',
            'title'=>'required',
            'content'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'f_a_q_category_id.required' => 'ՀՏՀ կատեգորիա դաշտը պարտադիր է',
            'title.required' => 'Հարցի տեքստ դաշտը պարտադիր է',
            'content.required' => 'Հարցի պատասխան դաշտը պարտադիր է',
        ];
    }
}
