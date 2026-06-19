<?php

namespace App\Services;

use App\Models\Notifikasi;

class NotificationService
{
    public function send(int $userId, string $type, string $title, string $message, ?int $fromUserId = null): Notifikasi
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
