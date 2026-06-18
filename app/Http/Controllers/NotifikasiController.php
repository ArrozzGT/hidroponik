<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifications = Notifikasi::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id !== auth()->id()) {
            abort(403);
        }
        $notifikasi->update(['is_read' => true]);
        return back();
    }

    public function markAllAsRead()
    {
        Notifikasi::where('user_id', auth()->id())->unread()->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }

    public static function send($userId, $type, $title, $message, $fromUserId = null)
    {
        return Notifikasi::create([
            'user_id' => $userId,
            'from_user_id' => $fromUserId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ]);
    }
}
