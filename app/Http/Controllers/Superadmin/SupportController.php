<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Mail\SupportReplyMail;
use App\Models\Support;
use App\Models\SupportReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{


    public function index(Request $request)
    {
        $query = Support::with(['user', 'assignedUser'])
            ->latest();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('subject', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($u) use ($request) {
                        $u->where('email', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $supports = $query->paginate(10);

        return view('superadmin.support.index', compact('supports'));
    }

    public function create()
    {
        $staffUsers = User::whereIn('role', [2, 3])->get();

        return view('superadmin.support.create', [
            'categories'  => Support::categories(),
            'staffUsers' => $staffUsers,
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'subject'     => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'priority'    => 'required|integer',
        ]);


        Support::create([
            'user_id'     => auth()->id(),
            'subject'     => $request->subject,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority'    => $request->priority,
            'assigned_to' => $request->assigned_to,
            'status'      => Support::STATUS_INACTIVE,
        ]);

        return redirect()->route(route: 'support')
            ->with('success', 'Support ticket created successfully');
    }

    public function show($id)
    {
        $staffUsers = User::whereIn('role', [2, 3])->get();
        $support = Support::findOrFail($id);
        $status = Support::statuses();
        return view('superadmin.support.show', compact('support', 'staffUsers', 'status'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Support::findOrFail($id);

        $request->validate([
            'admin_reply' => 'required|string',
            'status' => 'required|in:open,pending,resolved'
        ]);

        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.support.index')->with('success', 'Ticket updated and email sent');
    }


    public function updateStatus(Request $request, $id)
    {
        $support = Support::findOrFail($id);

        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Support::statuses()))
        ]);

        $support->status = $request->status;
        $support->save();

        return response()->json([
            'success' => true,
            'status_name' => $support->status_name
        ]);
    }


    public function destroy($id)
    {
        Support::findOrFail($id)->delete();
        return redirect()->route('support')->with('success', 'Ticket deleted');
    }


    public function assignTo(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $support = Support::findOrFail($id);
        $support->assigned_to = $request->assigned_to;
        $support->save();

        // Return JSON with updated user name
        return response()->json([
            'success' => true,
            'assigned_user_name' => $support->assignedUser->name,
        ]);
    }


    public function reply(Request $request, $id)
    {
        $support = Support::with(['user', 'reply'])->findOrFail($id);

        // 🚫 Block if already replied
        if ($support->reply) {
            return response()->json([
                'success' => false,
                'message' => 'This ticket already has a reply.'
            ], 422);
        }

        $request->validate([
            'reply' => 'required|string'
        ]);

        $reply = SupportReply::create([
            'support_id' => $support->id,
            'user_id'    => auth()->id(),
            'message'    => $request->reply,
        ]);

        // optional: auto-close ticket


        Mail::to($support->user->email)
            ->send(new SupportReplyMail($support, $reply));
        $support->update([
            'status' => Support::STATUS_CLOSED
        ]);
        return response()->json([
            'success' => true,
            'reply' => [
                'text' => $reply->message,
                'user' => auth()->user()->name,
                'time' => $reply->created_at->format('Y-m-d H:i')
            ]
        ]);
    }
}
