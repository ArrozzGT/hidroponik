<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PetaniProfile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function petaniPending()
    {
        $petani = User::where('role', 'petani')
            ->whereHas('petaniProfile', function($query) {
                $query->where('status_verifikasi', 'pending');
            })->latest()->get();
        
        return view('admin.users.petani-pending', compact('petani'));
    }

    public function verify(Request $request, User $user)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'alasan_reject' => 'required_if:action,reject',
        ]);

        $status = $request->action === 'approve' ? 'approved' : 'rejected';

        $user->petaniProfile->update([
            'status_verifikasi' => $status,
            'alasan_reject' => $request->action === 'reject' ? $request->alasan_reject : null,
            'verified_by' => auth()->id(),
        ]);

        if ($request->action === 'approve') {
            $user->update(['status' => 'aktif']);
            \App\Http\Controllers\NotifikasiController::send(
                $user->id,
                'verification',
                'Akun Disetujui',
                'Selamat! Akun petani Anda telah disetujui oleh Admin. Anda sekarang dapat menjual produk di SIPSH.',
                auth()->id()
            );
        } else {
            $user->update(['status' => 'nonaktif']);
            \App\Http\Controllers\NotifikasiController::send(
                $user->id,
                'verification',
                'Akun Ditolak',
                'Mohon maaf, akun petani Anda ditolak. Alasan: ' . ($request->alasan_reject ?? 'Tidak memenuhi syarat'),
                auth()->id()
            );
        }

        return back()->with('success', 'Status verifikasi petani berhasil diperbarui.');
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
