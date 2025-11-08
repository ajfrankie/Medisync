<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Display notifications for the logged-in user.
     */
    public function index(Request $request)
    {
        $notifications = app(NotificationRepository::class)
            ->getByUserId(Auth::id())
            ->paginate(10);

        return view('backend.notifications.index', [
            'notifications' => $notifications,
            'request' => $request,
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        try {
            $notification = app(NotificationRepository::class)->find($id);

            if (!$notification) {
                return redirect()->route('admin.notification.index')
                    ->with('error', 'Notification not found.');
            }

            app(NotificationRepository::class)->markAsRead($notification);

            return redirect()->route('admin.notification.index')
                ->with('success', 'Notification marked as read.');
        } catch (\Exception $e) {
            return redirect()->route('admin.notification.index')
                ->with('error', 'Failed to mark notification as read: ' . $e->getMessage());
        }
    }



    /**
     * Mark all notifications as read for the current user.
     */
    public function markAllAsRead()
    {
        try {
            app(NotificationRepository::class)->markAllAsRead();

            return back()->with('success', 'All notifications marked as read successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to mark all notifications as read', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', 'Failed to update notifications: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $notification = app(NotificationRepository::class)
            ->find($id);


        return view('backend.notifications.show', compact('notification'));
    }
}
