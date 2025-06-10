<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        } 

        $user = Auth::user();
        
        // Check user status first
        if ($user->status === 'submitted') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun anda masih menunggu persetujuan admin.']);
        }
        
        if ($user->status === 'rejected') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun anda telah ditolak admin.']);
        }

        $roleName = Role::find($user->role_id)->name;

        if (!in_array($roleName, $roles)) {
            return back()->withErrors(['email' => 'Anda tidak memiliki akses ke halaman ini.']);
        }
        
        return $next($request);
    }
}
