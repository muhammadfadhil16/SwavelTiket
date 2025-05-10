<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Notifications\Notifable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications;
        return view('user.notifications.index', compact('notifications'));

    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notifications,id',
        ]);

        $user = Auth::user();
        $notification = $user->notifications()->find($request->id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
    }
}
