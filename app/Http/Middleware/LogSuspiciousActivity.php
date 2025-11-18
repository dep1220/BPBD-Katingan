<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogSuspiciousActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log suspicious patterns
        $suspiciousPatterns = [
            'SELECT.*FROM',
            'UNION.*SELECT',
            '<script',
            'javascript:',
            '../',
            '<?php',
            'eval\(',
            'base64_decode',
        ];

        $input = json_encode($request->all());
        
        foreach ($suspiciousPatterns as $pattern) {
            if (stripos($input, $pattern) !== false) {
                Log::warning('Suspicious activity detected', [
                    'ip' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'pattern' => $pattern,
                    'user_agent' => $request->userAgent(),
                    'input' => $input,
                ]);
                break;
            }
        }

        return $next($request);
    }
}
