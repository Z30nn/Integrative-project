<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Fields that should NOT be sanitized (e.g. passwords).
     */
    protected array $skipFields = ['password', 'password_confirmation', 'current_password'];

    /**
     * Handle an incoming request — strip XSS from string inputs.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        $sanitized = $this->sanitize($input);
        $request->merge($sanitized);

        return $next($request);
    }

    protected function sanitize(array $data): array
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->skipFields)) {
                continue;
            }

            if (is_array($value)) {
                $data[$key] = $this->sanitize($value);
            } elseif (is_string($value)) {
                // Strip HTML tags and encode special chars to prevent XSS
                $data[$key] = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
            }
        }

        return $data;
    }
}
