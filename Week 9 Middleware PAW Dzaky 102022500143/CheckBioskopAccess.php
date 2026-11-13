<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBioskopAccess
{
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan beli tiket (login) terlebih dahulu sebelum masuk.');
        }

        $userRole = Auth::user()->role; 

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki tiket/wewenang untuk memasuki ruangan ini.');
        }

        return $next($request);
    }
}