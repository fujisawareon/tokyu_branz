<?php

use App\Http\Middleware\AuthBuilding;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            // TODO 管理者ルーティングの場合
            if ($request->routeIs('manager_*')) {
                return route('sara_login');
            }

            // TODO ユーザーのログイン画面
            // return route('user_login');

        });

        // カスタムミドルウェアを登録
        $middleware->alias([
            'auth.building' => AuthBuilding::class, // 物件を選択した良いか
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
