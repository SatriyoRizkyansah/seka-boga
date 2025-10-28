<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerProfileController extends Controller
{
    /**
     * Show customer profile page
     */
    public function show()
    {
        $user = Auth::user();
        return view('customer.profile.show', compact('user'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('customer.profile.edit', compact('user'));
    }

    /**
     * Update customer profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'alamat_lengkap' => ['nullable', 'string', 'max:500'],
            'kota' => ['nullable', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
        ]);

        User::where('id', $user->id)->update($validated);

        return redirect()->route('customer.profile.show')
                        ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show change password form
     */
    public function editPassword()
    {
        return view('customer.profile.change-password');
    }

    /**
     * Update customer password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        User::where('id', $user->id)->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('customer.profile.show')
                        ->with('success', 'Password berhasil diubah!');
    }
}