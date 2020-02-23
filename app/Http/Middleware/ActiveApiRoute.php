<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\ApiRoute;
use Closure;
use Illuminate\Http\Request;
use Str;

class ActiveApiRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $active = false;
        $activeRoutes = ApiRoute::where('active',1)->get();
        $activeRoutes->each(static function ($route) use (&$active) {
            // If the route contains {something} we need to replace it with
            // a matching pattern so we can filter and preg_match against it.
            preg_match($route->regex, request()->path(), $matches);

            if (!empty($matches)) {
                $active = true;
                return false;
            }
        });

        if (!$active) {
            return response()->json(['message' => 'route inactive'], 403);
        }

        return $next($request);
    }
}
