<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Basic auth sederhana
        $user = $request->getUser();
        $pass = $request->getPassword();

        // GANTI dengan username & password Anda
        $validUser = 'admin';
        $validPass = 'Loning2026!'; // password kuat!

        if ($user !== $validUser || $pass !== $validPass) {
            return response('Akses ditolak. Diperlukan login admin.', 401, [
                'WWW-Authenticate' => 'Basic realm="Admin DPT Loning"',
            ]);
        }

        return $next($request);
    }
}