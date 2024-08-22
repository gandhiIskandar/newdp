<?php

namespace App\Http\Middleware;

use App\Models\Whitelist;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhitelistIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //  $whitelistedIps = Whitelist::pluck('ip_address')->toArray();

        //  //  dd($request->ip());
        //  if (! in_array($request->ip(), $whitelistedIps)) {

        //      // Jika IP tidak ada dalam whitelist, kembalikan respon dengan status 403 Forbidden
        //      return response('Forbidden', Response::HTTP_FORBIDDEN);
        //  }

        return $next($request);
    }
}
