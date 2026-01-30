<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class TicketController extends Controller
{


    // Create a new ticket
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'priority' => 'required|integer',
            'email'        => 'required|email',
        ]);




        // Create Ticket
        $ticket = Support::create([
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


    public function show(Request $request, $id)
    {
        // Guest must provide email
        $request->validate([
            'email' => 'required|email'
        ]);

        $ticket = Support::whereNull('user_id')
            ->where('email', $request->email)
            ->where('id', $id)
            ->with('reply')
            ->first();

        // If no ticket found
        if (!$ticket) {
            return response()->json([
                'message' => 'Ticket not found or email does not match.'
            ], 404);
        }

        return response()->json($ticket);
    }



    // List all tickets for authenticated user
    public function index(Request $request)
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

}
