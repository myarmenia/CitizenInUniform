<?php

namespace App\Http\Requests;

use App\Models\PasswordBlackList;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ConfirmpPasswordChangesRequest extends FormRequest
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
        $user = User::where('email',$this->email)->first();


        $rules = [
            'new_password' => [
                function ($attribute, $value, $fail) use ($strongness,$user) {
                    if (!$user) {
                        $fail('Օգտատերը չի գտնվել');
                        return;
                    }

                    if (in_array($value, $strongness)) {
                        $fail('Գաղտնաբառը թույլ է: Խնդրում ենք ստեղծել ավելի բարդ գաղտնաբառ:');
                    }
                    if (Hash::check($value, $user->password)) {
                        $fail('Նոր գաղտնաբառը չի կարող լինել հին գաղտնաբառը');
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
            'new_password_confirmation' => [
                'required',
                'string',
                'min:8',
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

            'new_password.min'=>'Նոր գաղտնաբառը պետք է պարունակի առնվազն 8 նիշ',
            'new_password.regex'=>"Նոր գաղտնաբառը պետք է պարունակի առնվազն մեկ մեծատառ, մեկ փոքրատառ և մեկ թիվ",
            'new_password.confirmed' => 'Գաղտնաբառերը չեն համընկնում:',
        ];
    }
}
