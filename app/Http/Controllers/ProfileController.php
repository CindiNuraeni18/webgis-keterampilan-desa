<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'jabatan' => 'nullable|string|max:100',
            'nomor' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto profil harus jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Upload foto baru
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $path = $request->file('foto')->store('profile-photos', 'public');
            $user->foto = $path;
        }

        // Update data
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;
        $user->nomor = $request->nomor;
        $user->alamat = $request->alamat;
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.profile')->with('success_password', 'Password berhasil diganti.');
    }
}