<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is set in session
        $locale = session('locale', 'en');
        
        // Validate locale
        if (in_array($locale, ['en', 'kh'])) {
            app()->setLocale($locale);
        }
        
        return $next($request);
    }
}
