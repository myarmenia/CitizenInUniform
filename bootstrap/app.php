<?php

use App\Http\Middleware\CheckActionPermission;
use App\Http\Middleware\CheckActionPermissionForCategories;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,

            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,

            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

            'user' => UserMiddleware::class,
            'check_action_permission' => CheckActionPermission::class,
            'check_action_permission_for_category' => CheckActionPermissionForCategories::class,


        ]);
        $middleware->validateCsrfTokens(except: [
            'https://citizen.trigger.ltd/*',
            'http://127.0.0.1:8000/*',
            'http://localhost:8000/*',

        ]);


        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
