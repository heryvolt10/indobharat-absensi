<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomMidleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $url = $request->segment(1);

        if ($url == "" || $url == "login") {
            return $next($request);
        } else {
            $customRoutes = help_submenu_by_url($url);

            if ($customRoutes != '') {
                if (session('user_frole') != "1") {
                    $access = help_user_access_submenu($customRoutes[0]->id);

                    if ($access) {
                        if ($access->ishow !== 1) {
                            abort(403);
                        }
                    } else {
                        abort(403);
                    }
                }
            }

            return $next($request);
        }
    }
}
