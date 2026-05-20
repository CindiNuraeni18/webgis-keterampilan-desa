<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Proses login custom
     */
    public function login(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ], [
        'email.required' => 'email dan password salah',
        'password.required' => 'email dan password salah',
        'email.email' => 'email salah',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    // Jika email tidak ditemukan, anggap email dan password salah
    if (!$user) {
        throw ValidationException::withMessages([
            'email' => ['email dan password salah'],
            'password' => ['email dan password salah'],
        ]);
    }

    // Jika password tidak cocok
    if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => ['password salah'],
        ]);
    }

    \Illuminate\Support\Facades\Auth::login($user, $request->filled('remember'));
    $request->session()->regenerate();

    return redirect('/admin/dashboard');
}

    /**
     * Username yang dipakai untuk login
     */
    public function username()
    {
        return 'email';
    }
}