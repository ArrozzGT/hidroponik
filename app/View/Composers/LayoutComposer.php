<?php

namespace App\View\Composers;

use App\Models\Cart;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view): void
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        $notifCount = Notifikasi::where('user_id', $user->id)->unread()->count();
        $cartCount = Cart::where('user_id', $user->id)->count();

        $view->with(compact('notifCount', 'cartCount'));
    }
}
