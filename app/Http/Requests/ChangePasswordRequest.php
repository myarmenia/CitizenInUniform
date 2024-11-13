<?php

namespace App\Http\Requests;

use App\Models\PasswordBlackList;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

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
        $strongness = PasswordBlackList::all()->pluck('password')->toArray();

        $rules = [
            'old_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'new_password' => [
                function ($attribute, $value, $fail) use ($strongness) {
                    if (in_array($value, $strongness)) {
                        $fail('Գաղտնաբառը թույլ է: Խնդրում ենք ստեղծել ավելի բարդ գաղտնաբառ:');
                    }
                    if (Hash::check($value, auth()->user()->password)) {
                        $fail('Նոր գաղտնաբառը չի կարող լինել ընթացիկ գաղտնաբառը');
                    }
                },
                'required',
                'confirmed',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',

            ],
        ];

        $rules[ 'old_password'] = ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('Ընթացիկ գատնաբառը սխալ է');
                }
            }];

        return $rules;

    }
    public function messages()
    {
        return [
            'old_password.min'=>'Գաղտնաբառը պետք է պարունակի առնվազն 8 նիշ',
            'old_password.regex'=>"Գաղտնաբառը պետք է պարունակի առնվազն մեկ մեծատառ, մեկ փոքրատառ և մեկ թիվ",
            'new_password.min'=>'Նոր գաղտնաբառը պետք է պարունակի առնվազն 8 նիշ',
            'new_password.regex'=>"Նոր գաղտնաբառը պետք է պարունակի առնվազն մեկ մեծատառ, մեկ փոքրատառ և մեկ թիվ",
            'new_password.confirmed' => 'Գաղտնաբառերը չեն համընկնում:',
        ];
    }
}
