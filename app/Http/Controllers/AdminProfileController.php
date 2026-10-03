<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.profile.edit', ['admin' => $request->user()]);
    }

    public function update(Request $request)
    {
        $admin = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($admin->id)],
            'current_password' => [
                'nullable',
                Rule::requiredIf(fn () => filled($request->input('password')) || $request->input('email') !== $admin->email),
                'current_password',
            ],
            'password' => ['nullable', 'string', 'min:12', 'confirmed'],
        ], [
            'current_password.current_password' => 'Your current password is incorrect.',
            'password.min' => 'Choose a password with at least 12 characters.',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        if (filled($validated['password'] ?? null)) {
            $admin->password = $validated['password'];
        }
        $admin->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Your admin profile has been updated.');
    }
}
