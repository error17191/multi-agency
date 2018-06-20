<?php

namespace App\Http\Middleware;

use App\Agency;
use Closure;

class SetAgency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Agency::current($agency = Agency::findByUidOrFail($request->agency));

        return $next($request);
    }
}
