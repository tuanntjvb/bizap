<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    const WHITE_LIST = [
        'html_',
    ];

    public function handle(Request $request, Closure $next)
    {
        $input = $request->input();
        array_walk_recursive($input, function (&$input, $key) {
            if (starts_with($key, self::WHITE_LIST)) {
                return;
            }
            if (!is_null($input)) {
                $input = e(strip_tags($input));
            }
        });
        $request->merge($input);
        return $next($request);
    }
}