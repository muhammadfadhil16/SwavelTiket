<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use \App\Notifications\LoginNotification;
use \App\Notifications\RegistrationNotification;
use \App\Notifications\LogoutNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_user' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email_user', $request->input('email_user'))
            ->orWhere('name_user', $request->input('email_user'))
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Kirim notifikasi login
            $user->notify(new LoginNotification($user->name_user, now()->toDateTimeString()));

            return $this->redirectUserByRole('catalogue.index')->with('status', 'success');
        }

        return back()->with('status', 'error');
    }

    public function redirectUserByRole($route)
    {
        if (Auth::user()->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->role === 'User') {
            return redirect()->route('catalogue.index');
        }

        return redirect()->route($route);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name_user' => 'required|string',
            'email_user' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|in:admin,user',
        ]);


        $role = $request->role ?? 'User';


        $user = User::create([
            'name_user' => $request->name_user,
            'email_user' => $request->email_user,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        $user->notify(new RegistrationNotification($user->name_user));

        Auth::login($user);


        return $this->redirectUserByRole('catalogue.index')->with('status', 'register');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalogue.index')->with('status', 'logout');
    }
}
