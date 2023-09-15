<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role)
    {
        $role = Roles::with(['menu' => function ($query) {
            $query->with('menu_detail');
            $query->with('sub_menu.sub_menu_detail');
        }])->where('id', Auth::user()->id_role)->first();

        view()->share('role', $role);
        return $next($request);
    }
}
