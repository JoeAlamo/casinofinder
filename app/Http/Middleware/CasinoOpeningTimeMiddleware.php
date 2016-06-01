<?php

namespace CasinoFinder\Http\Middleware;

use Closure;

class CasinoOpeningTimeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Transform day[x], open_time[x], close_time[x] into
        // opening_time[x]['day' => VAL, 'open_time' => VAL, 'close_time' => VAL]

        $opening_time = [];
        $days = $request->input('day', []);
        $openTimes = $request->input('open_time', []);
        $closeTimes = $request->input('close_time', []);

        foreach ($days as $key => $value) {
            $opening_time[$key]['day'] = $days[$key];
            $opening_time[$key]['open_time'] = $openTimes[$key];
            $opening_time[$key]['close_time'] = $closeTimes[$key];
        }

        $request->merge(['opening_time' => $opening_time]);

        return $next($request);
    }
}
