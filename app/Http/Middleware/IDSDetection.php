<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class IDSDetection
{
    public function handle($request, Closure $next)
    {
        $suspiciousPatterns = [
            // XSS
            '/<script.*?>.*?<\/script>/i' => 'XSS (Script Injection)',
            '/on\w+\s*=\s*["\'].*?["\']/i' => 'XSS (Inline Event Handler)',
            '/javascript:/i' => 'XSS (JS in Attribute)',

            // SQL Injection
            '/(union.*select|drop\s+table|insert\s+into|or\s+1=1|--)/i' => 'SQL Injection',

            // Directory Traversal
            '/\.\.\/\.\./' => 'Directory Traversal',

            // Remote File Inclusion (RFI) and Local File Inclusion (LFI)
            '/(http[s]?:\/\/|file:\/\/|php:\/\/input)/i' => 'RFI/LFI',

            // Command Injection
            '/(;|\|\||&&|\|)/' => 'Command Injection',
        ];

        $content = $request->getContent();
        $queryParams = $request->query();

        foreach ($queryParams as $param) {
            foreach ($suspiciousPatterns as $pattern => $attackName) {
                if (preg_match($pattern, $param)) {
                    Log::channel('ids')->alert('Possible intrusion detected', [
                        'ip' => $request->ip(),
                        'url' => $request->fullUrl(),
                        'payload' => $param,
                        'attack' => $attackName,
                    ]);

                    abort(403, 'Unauthorized action.');
                }
            }
        }

        foreach ($suspiciousPatterns as $pattern => $attackName) {
            if (preg_match($pattern, $content)) {
                Log::channel('ids')->alert('Possible intrusion detected', [
                    'ip' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'payload' => $content,
                    'attack' => $attackName,
                ]);

                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}
