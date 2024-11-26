<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AuthLoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => [
                'required',

                function ($attribute, $value, $fail) {
                    $credentials = $this->only('email', 'password');
                    $ipAddress = request()->ip();
                    if (!Auth::attempt($credentials)) {
                        \App\Models\UserLoginLog::create([
                            'ip' => $ipAddress,
                            'date' => now(),
                            'status' => 0, // Failed login
                            'email' => $this->email,
                        ]);
                        $fail('Գաղտնաբառը կամ մուտքանունը սխալ է');
                    }else{
                        \App\Models\UserLoginLog::create([
                            'ip' => $ipAddress,
                            'date' => now(),
                            'status' => 1, // Failed login
                            'email' => $this->email,
                        ]);

                    }

                },
            ],
        ];
    }

}
