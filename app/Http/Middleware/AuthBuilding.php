<?php

namespace App\Http\Middleware;

use App\Models\Manager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AuthBuilding
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Manager $manager_user */
        // システム管理者かサービス管理者であれば事後確認をせずに通す
        $manager_user = Auth::guard('managers')->user();
        if (
            $manager_user->role_type == Manager::ROLE_TYPE_SARA ||
            $manager_user->role_type == Manager::ROLE_TYPE_SERVICE
        ) {
            return $next($request);
        }

        $building = $request->route('building');
        if (!is_null($building)) {
            if (!Gate::allows('access-building', $building)) {
                dd('作成中');
                return $next($request);
            }
        }

        return $next($request);
    }
}