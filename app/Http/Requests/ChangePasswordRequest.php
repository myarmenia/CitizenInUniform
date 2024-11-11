<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
        $rules = [


            'currentPassword' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'confirmNewPassword' => [
                'required',
                'string',
                'min:8',
                'same:newPassword',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ];
        return $rules;

    }
    public function messages()
    {
        return [
            'currentPassword.min'=>'Գաղտնաբառը պետք է պարունակի առնվազն 8 նիշ',
            'currentPassword.regex'=>"Գաղտնաբառը պետք է պարունակի առնվազն մեկ մեծատառ, մեկ փոքրատառ և մեկ թիվ",
            // 'confirmNewPassword.min'=>'Նոր գաղտնաբառը պետք է պարունակի առնվազն 8 նիշ',
            // 'confirmNewPassword.regex'=>"Նոր գաղտնաբառը պետք է պարունակի առնվազն մեկ մեծատառ, մեկ փոքրատառ և մեկ թիվ",
        ];
    }
}
