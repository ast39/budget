<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LanguageManager {

    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}
