<?php

namespace App\Http\Requests;

use App\Models\PasswordBlackList;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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


        $strongness = PasswordBlackList::all()->pluck('password')->toArray();
        $currentRoute = Route::currentRouteName();

        $rules = [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required',
        ];

        if($currentRoute=='users.store')

            $rules['password'] = [
                    function ($attribute, $value, $fail) use ($strongness) {

                        if (in_array($value, $strongness)) {
                            $fail('Գաղտնաբառը թույլ է: Խնդրում ենք ստեղծել ավելի բարդ գաղտնաբառ:');
                        }

                    },
                    'required',
                    'string',
                    'min:8',
                    'same:confirmPassword',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',

                ];


        if($this->phone!=null){
            $rules['phone'] = 'regex:/^\\+\\d{1,3}\\d{9,11}$/';
        }
        if($currentRoute == 'users.update'){
            // dd(888);

            $userId = $this->route('user');
            $rules['email']='required|email|unique:users,email,'.$userId;

            if($this->password !=null){




                $rules['password'] = [
                    function ($attribute, $value, $fail) use ($strongness) {
                        // dd($attribute, $value, $fail);
                      
                        if (in_array($value, $strongness)) {
                            $fail('Գաղտնաբառը թույլ է: Խնդրում ենք ստեղծել ավելի բարդ գաղտնաբառ:');
                        }

                    },

                    'string',
                    'min:8',
                    'same:confirmPassword',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                ];
            }
        }

        return $rules;

    }
    public function messages()
    {
        return [
            'password.min'=>'Գաղտնաբառը պետք է պարունակի առնվազն 8 նիշ',
            'password.regex'=>"Գաղտնաբառը պետք է պարունակի առնվազն մեկ մեծատառ, մեկ փոքրատառ և մեկ թիվ",
            'phone.regex' => 'Հեռախոսահամարը պետք է սկսվի  "+"նշանով, որին հաջորդում է երկրի կոդը  (1-3 նիշ) և առավելագույնը  11 թվային նիշ',
        ];
    }
}
