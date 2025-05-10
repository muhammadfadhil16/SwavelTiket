<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Menampilkan semua notifikasi untuk admin.
     */
    public function index()
    {
        // Pastikan hanya admin yang dapat mengakses
        $admin = Auth::user();
        if (!$admin->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil semua notifikasi milik admin yang sedang login
        $notifications = $admin->notifications;

        // Kirim ke view
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Menandai notifikasi sebagai dibaca.
     */
    public function markAsRead(Request $request)
    {
        // Pastikan hanya admin yang dapat mengakses
        $admin = Auth::user();
        if (!$admin->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi request
        $request->validate([
            'id' => 'required|exists:notifications,id',
        ]);

        // Cari notifikasi berdasarkan ID
        $notification = $admin->notifications()->find($request->id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
    }

    /**
     * Menghapus notifikasi.
     */
    public function delete(Request $request)
    {
        // Pastikan hanya admin yang dapat mengakses
        $admin = Auth::user();
        if (!$admin->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi request
        $request->validate([
            'id' => 'required|exists:notifications,id',
        ]);

        // Cari notifikasi berdasarkan ID
        $notification = $admin->notifications()->find($request->id);

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true, 'message' => 'Notification deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
    }
}
