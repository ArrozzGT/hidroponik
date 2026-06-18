<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:petani,pembeli'],
            'no_hp' => ['required', 'string', 'max:15'],
        ];

        if ($request->role === 'petani') {
            $rules['nama_kebun'] = ['required', 'string', 'max:255'];
            $rules['lokasi_kebun'] = ['required', 'string', 'max:255'];
            $rules['deskripsi_kebun'] = ['nullable', 'string', 'max:1000'];
        } else {
            $rules['lokasi_kebun'] = ['nullable', 'string', 'max:255'];
        }

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->lokasi_kebun,
            'status' => $request->role === 'petani' ? 'nonaktif' : 'aktif',
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'petani') {
            \App\Models\PetaniProfile::create([
                'user_id' => $user->id,
                'nama_kebun' => $request->nama_kebun,
                'lokasi_kebun' => $request->lokasi_kebun,
                'deskripsi_kebun' => $request->deskripsi_kebun,
                'status_verifikasi' => 'pending',
            ]);
        } else {
            \App\Models\PembeliProfile::create([
                'user_id' => $user->id,
            ]);
        }

        \App\Models\ActivityLog::log('register', 'User baru mendaftar sebagai ' . $request->role . ': ' . $user->name);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->hasRole('admin')) {
            return redirect(route('admin.dashboard'));
        } elseif ($user->hasRole('petani')) {
            return redirect(route('petani.dashboard'));
        } else {
            return redirect(route('pembeli.dashboard'));
        }
    }
}
