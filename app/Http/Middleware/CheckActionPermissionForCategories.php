<?php

namespace App\Http\Middleware;

use App\Helpers\MyHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckActionPermissionForCategories
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $modelClass): Response
    {

        $governing_body_id = MyHelper::getAuthUserGoverningBodyId();

        $routeParameters = $request->route()->parameters();
        $modelId = reset($routeParameters); // Получаем первый параметр маршрута

        // Проверяем существование модели
        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Model not found'], 403);
        }

        // Ищем модель по ID
        $model = $modelClass::find($modelId);

        if (!$model) {
            return response()->json(['error' => 'Resource not found'], 403);
        }

        if($model->getTable() == 'categories' ){
            if (($governing_body_id == 1 && $model->id == 2) || ($governing_body_id == 2 && $model->id == 1)) {

                return response()->json(['error' => 'Access denied'], 403);
            }
        }
        else{
            if (($governing_body_id == 1 && $model->category_id == 2) || ($governing_body_id == 2 && $model->category_id == 1)) {

                return response()->json(['error' => 'Access denied'], 403);
            }

        }


        return $next($request);
    }
}
