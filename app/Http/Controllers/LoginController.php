<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.'])->withInput();
        }

        if (password_verify($credentials['password'], $user->password)) {
            // Authentication successful
            // You can log in the user here if needed
            // For example, you can set a session variable
            // or perform any custom logic you require

            Auth::login($user); // Log in the user

            return redirect('/dashboard')->with('success', 'Login successful!');
        }

        // Authentication failed
        return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user

        // Perform any necessary logout actions
        // For example, clearing session variables

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
