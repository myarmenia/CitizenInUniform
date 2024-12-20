<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Staff;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use App\Models\GoverningBody;
use App\Models\GoverningBodyUser;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class UserRepository implements UserRepositoryInterface
{
    public function index(){

        $authUser = Auth::user();
        $query = User::query()
                ->where('users.id', '!=', $authUser->id);

        if ($authUser->hasRole('super_admin') ) {

            $query->whereHas('roles', function ($query) {
                $query->where('position_name', '=', 'super_admin');
            });
        }
        elseif($authUser->hasRole('admin')){

            $query->whereHas('roles', function ($query) {
                $query->where('position_name', '=', 'admin');
            });
        }
        return  $query->orderBy('id','desc')->get();

    }
    public function store(array $data): User
    {

        $user = User::create($data);
        $user->password_changes_at = $user->created_at;
        $user->save();

        $user->assignRole($data['roles']);

        foreach($data['roles'] as $role){
            if($role=="operatorMIP" || $role=="operatorPN"){
                $explode = explode('operator',$role);
         
                $governingBody=GoverningBody::where('named',$explode[1])->value('id');

                $governing_body_users=GoverningBodyUser::create([
                    "user_id"=>$user->id,
                    "governing_body_id"=>$governingBody,
                ]);
            }
        }


        return $user;

    }
    public function update($id, $data){


        $user=User::where('id',$id)->first();

        $user->update($data);
        $user->password_changes_at = $user->updated_at;
        $user->save();
        $user->roles()->detach();
        $user->assignRole($data['roles']);

        foreach($data['roles'] as $role){
            if($role == "operatorMIP" || $role == "operatorPN"){

                $explode = explode('operator',$role);

                $governingBody=GoverningBody::where('named',$explode[1])->value('id');

                $governing_body_users=GoverningBodyUser::where('user_id',$id)->first();
                if($governing_body_users){
                    $governing_body_users->governing_body_id=$governingBody;
                    $governing_body_users->save();
                }else{
                    $governing_body_users=GoverningBodyUser::create([
                        "user_id"=>$user->id,
                        "governing_body_id"=>$governingBody,
                    ]);
                }

            }
        }
        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        // Поиск пользователя по email
        return User::where('email', $email)->first();
    }
}

