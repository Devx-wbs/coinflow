<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // List all tickets for authenticated user
    public function index(Request $request)
    {
        $tickets = Support::where('user_id', auth()->id())
            ->with('reply')
            ->latest()
            ->paginate(10);

        return response()->json($tickets);
    }


    public function guestIndex(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $tickets = Support::whereNull('user_id')
            ->where('email', $request->email)
            ->with('reply')
            ->latest()
            ->paginate(10);

        return response()->json($tickets);
    }


    public function show(Request $request, $id)
    {
        // ✅ Case 1: Authenticated User
        if (auth()->check()) {

            $ticket = Support::where('user_id', auth()->id())
                ->with('reply')
                ->findOrFail($id);

            return response()->json($ticket);
        }

        // ✅ Case 2: Guest User
        // Guest must provide email
        $request->validate([
            'email' => 'required|email'
        ]);

        $ticket = Support::whereNull('user_id')
            ->where('email', $request->email)
            ->with('reply')
            ->findOrFail($id);

        return response()->json($ticket);
    }


    // Create a new ticket
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'priority' => 'required|integer',
            'email'        => 'nullable|email',
        ]);


        // Check if user is authenticated
        $userId = auth()->id();

        // If user not logged in, email must be provided
        if (!$userId && !$request->email) {
            return response()->json([
                'message' => 'Email is required for guest ticket creation.'
            ], 422);
        }


        // Create Ticket
        $ticket = Support::create([
            'user_id'      => $userId,              // null if guest
            'email'        => $request->email,      // stored for guest
            'subject'      => $request->subject,
            'description'  => $request->description,
            'category_id'  => $request->category_id,
            'priority'     => $request->priority,
            'status'       => Support::STATUS_INACTIVE,
        ]);


        return response()->json([
            'message' => 'Ticket created successfully',
            'ticket'  => $ticket
        ], 201);
    }

    // Update ticket (only if no reply yet)
    public function update(Request $request, $id)
    {
        $ticket = Support::where('user_id', auth()->id())
            ->with('reply')
            ->findOrFail($id);

        if ($ticket->reply) {
            return response()->json([
                'message' => 'Cannot update ticket after admin reply.'
            ], 403);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'priority' => 'required|integer',
        ]);

        $ticket->update($request->only('subject', 'description', 'category_id', 'priority'));

        return response()->json($ticket);
    }
}
