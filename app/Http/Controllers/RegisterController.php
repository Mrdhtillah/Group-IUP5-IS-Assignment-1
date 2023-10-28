<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'consent' => 'accepted', // Requires the checkbox to be checked
        ];

        // Validate the incoming data
        $validator = Validator::make($request->all(), $rules, [
            'consent.accepted' => 'You must consent to the terms and conditions.',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'consent' => true, // You can customize this based on your consent handling
        ]);

        // Redirect the user to the dashboard or any other page
        return redirect('/login')->with('success', 'Registration successful!');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'consent' => ['accepted'], // Requires the checkbox to be checked
        ], [
            'consent.accepted' => 'You must consent to the terms and conditions.',
        ]);
    }
}
