<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationEmailJob;
use App\Models\Notification;
use App\Models\NotificationLog;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PushNoticeController extends Controller
{
    public function store(Request $request)
    {


        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'role_id' => 'required'
        ]);

        $isDraft = $request->action === 'draft';
        $notification = Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'role_id' => $request->role_id,
            'status'  => $isDraft ? 'draft' : 'queued',
        ]);

       
        if ($isDraft) {
            return redirect()
                ->route('push.notice.index', ['tab' => 'draft'])
                ->with('success', 'Notification saved as draft.');
        }
        $users = Notification::getUsersByTarget($request->role_id);


        foreach ($users as $user) {
            $log = NotificationLog::create([
                'notification_id' => $notification->id,
                'user_id' => $user->id
            ]);

            SendNotificationEmailJob::dispatch($log);
        }

        return back()->with('success', 'Notification queued successfully!');
    }


    public function index(Request $request)
    {
        $tab = $request->get('tab', 'create');

        $query = Notification::latest();

        // 🔹 Filter based on tab
        if ($tab === 'draft') {
            $query->where('status', 'draft');
        } elseif ($tab === 'history') {
            $query->whereIn('status', ['queued', 'sent']);
        }

        $notifications = $query->paginate(10);

        $targetAudiences = Notification::targetAudiences();

        // Dashboard Stats
        $stats = [
            'total_notices' => Notification::count(),

            'draft_notices' => Notification::where('status', 'draft')->count(),

            'total_delivered' => NotificationLog::where('status', 'sent')->count(),

            'delivered_this_month' => NotificationLog::where('status', 'sent')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
        ];

        return view('superadmin.notifications.index', compact(
            'tab',
            'notifications',
            'targetAudiences',
            'stats'
        ));
    }


    public function show(Notification $notification)
    {
        // Load logs with users
        $logs = NotificationLog::with('user')
            ->where('notification_id', $notification->id)
            ->get();

        $targetAudiences = Notification::targetAudiences();
        return view('superadmin.notifications.show', compact('notification', 'logs', 'targetAudiences'));
    }



    /**
     * Update notification message
     */
    public function update(Request $request, Notification $notification)
    {

        if ($notification->status !== 'draft') {
            return back()->with('error', 'You cannot update a queued or sent notification.');
        }
        $request->validate([
            'title'   => 'required|string',
            'message' => 'required|string',
            'role_id' => 'required|integer',
        ]);

        // ✅ Only update fields (NO DISPATCH)
        $notification->update([
            'title'   => $request->title,
            'message' => $request->message,
            'role_id' => $request->role_id,
        ]);

        return redirect()
            ->route('push.notice.show', $notification->id)
            ->with('success', 'Notification updated successfully.');
    }


    public function resend(Notification $notification)
    {
        if ($notification->status !== 'draft') {
            return back()->with('error', 'Only draft notifications can be sent.');
        }

        // Mark queued
        $notification->update([
            'status' => 'queued',
        ]);

        $users = Notification::getUsersByTarget($notification->role_id);

        foreach ($users as $user) {

            $log = NotificationLog::create([
                'notification_id' => $notification->id,
                'user_id'         => $user->id,
                'status'          => 'pending',
            ]);

            // ✅ Dispatch for each user
            SendNotificationEmailJob::dispatch($log);
        }

        return back()->with('success', 'Notification sent successfully!');
    }

    public function edit(Notification $notification)
    {
        if ($notification->status !== 'draft') {
            return back()->with('error', 'Only draft notifications can be edited.');
        }

        $targetAudiences = Notification::targetAudiences();

        return view('superadmin.notifications.edit', compact(
            'notification',
            'targetAudiences'
        ));
    }
}
