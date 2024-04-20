<?php

namespace App\Http\Middleware;

use App\Models\StatusApplicantsRegistration;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $register = StatusApplicantsRegistration::where('identity_user', Auth::user()->identity)->first();
        if ($register && Auth::user()->role == 'S') {
            return $next($request);
        }
        return back()->with('error', "Untuk mengisi data rekomendasi, anda harus registrasi terlebih dahulu.");
    }
}
