<?php

namespace App\Http\Middleware;

use App\Helpers\MyHelper;
use App\Models\GoverningBodyUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = Auth::user();
        $governing_body_id = MyHelper::getAuthUserGoverningBodyId();
    
        $routeParameters = $request->route()->parameters();
        // dd($routeParameters);
        $modelId = reset($routeParameters); // Получаем первый параметр маршрута

        $userGoverningBody = GoverningBodyUser::where('user_id',$modelId)->value('governing_body_id');

        if(!$authUser->hasAnyRole(['super_admin', 'adminMIP','adminPN'])){


                 return response()->json(['message',"You dont have permition"],403);

        }
        if($authUser->hasAnyRole(['adminMIP','adminPN']))
        {

            if(isset($userGoverningBody)){

                 if($governing_body_id!=$userGoverningBody){

                return response()->json(['message',"You dont have permition"],403);
            }

            }



        }



        // dd($governing_body_id, $modelId, $userGoverningBody);
        // if($governing_body_id!=$userGoverningBody){
        //     return response()->json(['message',"You dont have permition"],403);
        // }
        return $next($request);
    }
}
