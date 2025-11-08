<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationRepository
{
    protected $model;

    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }

    /**
     * Get all notifications (with optional filtering).
     */
    public function get(Request $request)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    /**
     * Find notification by ID.
     */
    public function find($id)
    {
        return Notification::find($id); // returns null if not found
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($notification)
    {
        $notification->is_viewed = true;
        return $notification->save();
    }

    /**
     * Mark all notifications for the logged-in user as read.
     */
    public function markAllAsRead()
    {
        return $this->model
            ->where('user_id', Auth::id())
            ->where('is_viewed', false)
            ->update(['is_viewed' => true]);
    }

    /**
     * Get notifications for a specific user ID.
     */
    public function getByUserId($userId)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get latest notifications for topbar (default 3)
     */
    public function getLatestNotifications($limit = 3)
    {
        return $this->model
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Count unread notifications for the logged-in user
     */
    public function countUnread()
    {
        return $this->model
            ->where('user_id', Auth::id())
            ->where('is_viewed', false)
            ->count();
    }
}
