<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmpPasswordChangesRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ConfirmPasswordChangesController extends Controller
{
    public function __invoke(ConfirmpPasswordChangesRequest $request){

        $data = User::where('email',$request->email)->first();

        $data->password = $request->new_password;
        $data->save();
        $user=User::findOrFail($data->id);
        $user->password_changes_at = $data->updated_at;
        $user->save();
        return response()->json(['message' => 'Successfully logged out'],200);
    }
}
