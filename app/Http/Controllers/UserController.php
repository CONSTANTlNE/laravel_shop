<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        return view('frontend.customer.dashboard');

    }

    public function profileHtmx(Request $request)
    {

        return view('frontend.customer.profile_htmx');
    }

    public function updateProfile(Request $request)
    {

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'mobile' => 'nullable|min:9|max:9',
            'pid' => [
                'nullable',
                'regex:/^(\d{9}|\d{11})$/',
            ],
        ]);

        $user = auth('web')->user();

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->password = bcrypt($request->password);
        }

        if ($request->filled('name') && $request->name != $user->name) {
            $user->name = trim($request->name);
        }

        if ($request->filled('email') && $request->email != $user->email) {
            $user->email = trim($request->email);
        }

        if ($request->filled('mobile') && $request->mobile != $user->mobile) {
            $user->mobile = trim($request->mobile);
            $user->mobile_verified = false;
        }

        if ($request->filled('pid') && $request->pid != $user->pid) {
            $user->pid = trim($request->pid);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');

    }
}
