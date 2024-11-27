<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Models\PasswordPolicy;
use App\Models\UserLoginLog;
use Carbon\Carbon;
use Illuminate\Http\Request;




class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request)
    {

        $credentials = request(['email', 'password']);

        $token = auth()->attempt($credentials);
        $user = auth()->user();
        if($token){
            $user->online=1;
            $user->save();
        }





        // Check if the user's status is 1
        if ($user->status != 1) {

            return response()->json(['errors'=>['password'=>[0 => 'Գաղտնաբառը կամ մուտքանունը սխալ է']]], 422);
        }


        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $message='';
        $currentDate = Carbon::now();
        $user =  auth()->user();

        $password_polici = PasswordPolicy::where('id',1)->first();

        $passwordChangedAt = $user->password_changes_at ? Carbon::parse($user->password_changes_at) : null;

        if ($passwordChangedAt && $passwordChangedAt->diffInDays($currentDate) >= 180) {

                $message = 'Ձեր գաղտնաբառի վավերականության ժամկետը սպառվել է, խնդրում ենք փոփոխել այն:';

        }

        $data=Auth::user()->load('roles');
        $data['message']=$message;

        return response()->json($data);


    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->user()->online=0;
        auth()->user()->save();

        auth()->logout();





        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {



        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,

        ]);


    }
}
