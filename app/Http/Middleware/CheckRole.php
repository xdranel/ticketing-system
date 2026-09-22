<?php

namespace App\Http\Middleware;

use BackedEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        $userRole = $user?->role instanceof BackedEnum ? $user->role->value : $user?->role;

        if (! $user || ! in_array($userRole, $roles, true)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
