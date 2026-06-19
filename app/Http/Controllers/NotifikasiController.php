<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\ActivityLog;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

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

    public function send($userId, $type, $title, $message, $fromUserId = null)
    {
        return $this->notificationService->send($userId, $type, $title, $message, $fromUserId);
    }
}
