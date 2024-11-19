<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends BaseController

{
    
    public function index(ChangePasswordRequest $request){

        $data = User::where('id',Auth::id())->first();

        $data->password = $request->new_password;
        $data->save();
        $user=User::findOrFail($data->id);
        $user->password_changes_at = $data->updated_at;
        $user->save();



        return response()->json(['message' => 'Successfully logged out'],200);

    }
}
