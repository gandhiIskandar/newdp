<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Website;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Website1
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $arrayWebId=Website::whereNotIn('id',[5,6])->pluck('id')->toArray(); // ambil data website selain tt atas dan fitur umum
    
        $website_session = session('website_id');
        if(!in_array($website_session, $arrayWebId)){

            return redirect('dashboard');

        }

        return $next($request);
    }
}
