@extends('layouts.user_type.auth')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Ticket Details</h4>

    <!-- Move To Dropdown -->
    <div class="dropdown d-inline me-2">
        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="moveToDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Move To
        </button>
        <ul class="dropdown-menu" aria-labelledby="moveToDropdown">
            @foreach($staffUsers as $staff)
            <li>
                <a class="dropdown-item assign-user" href="#"
                    data-id="{{ $staff->id }}"
                    data-support-id="{{ $support->id }}">
                    {{ $staff->name }}
                </a>
            </li>
            @endforeach
        </ul>
        <a href="{{ route('support') }}" class="btn btn-secondary btn-sm">Back to Tickets</a>
    </div>

</div>
<div id="assignMessage" class="alert alert-success" style="display: none;"></div>
<div class="row">
    <!-- Left Panel: Ticket & Reply -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h5>{{ $support->subject }}</h5>
                <p class="text-muted mb-1">
                    Ticket ID: <strong>TK-{{ str_pad($support->id, 3, '0', STR_PAD_LEFT) }}</strong>
                </p>
                <p class="text-muted mb-1">
                    Created: {{ optional($support->created_at)->format('Y-m-d H:i') }}
                </p>
                <hr>
                <strong>Description</strong>
                <p>{{ $support->description }}</p>
                <hr>

                <!-- Reply Form -->

                <hr>
                <h6>Reply</h6>

                <div id="replyList">
                    @if($support->reply)
                    <div class="border rounded p-3 mb-3 bg-light">
                        <strong>
                            {{ $support->reply->user->name }}
                            <small class="text-muted">
                                • {{ $support->reply->created_at->format('Y-m-d H:i') }}
                            </small>
                        </strong>
                        <p class="mb-0 mt-1">{{ $support->reply->message }}</p>
                    </div>
                    @else
                    <p class="text-muted">No reply yet.</p>
                    @endif
                </div>
                @if(!$support->reply)
                <form id="replyForm">
                    @csrf
                    <div class="mb-2">
                        <label for="reply">Reply to Customer</label>
                        <textarea class="form-control" id="reply" name="reply" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Send Reply</button>
                </form>
                @endif

                <div id="replyMessage" class="mt-2"></div>
            </div>
        </div>
    </div>

    <!-- Right Panel: Ticket Info & Status -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h6>Ticket Information</h6>
                <p><strong>Customer:</strong> {{ $support->user->name ?? '-' }}</p>
                <p><strong>Email:</strong> {{ $support->user->email ?? '-' }}</p>
                <p><strong>Assigned To : <span id="assignedUserName">{{ $support->assignedUser->name ?? '-' }}</span></strong></p>
                <p><strong>Date Created:</strong> {{ optional($support->created_at)->format('Y-m-d') }}</p>
                <p><strong>Status:</strong></p>
                <select id="statusSelect" class="form-select">
                    @foreach($status as $key => $label)
                    <option value="{{ $key }}" {{ $support->status == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>

            </div>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {


       const replyForm = document.getElementById('replyForm');
    const replyList = document.getElementById('replyList');
    const replyMessage = document.getElementById('replyMessage');

    if (replyForm) {
        replyForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('support.reply', $support->id) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Append new reply instantly
                    replyList.innerHTML = `
                        <div class="border rounded p-3 mb-3 bg-light">
                            <strong>
                                ${data.reply.user}
                                <small class="text-muted">• just now</small>
                            </strong>
                            <p class="mb-0 mt-1">${data.reply.text}</p>
                        </div>
                    `;

                    // Reset and hide form after reply
                    replyForm.remove();
                    replyMessage.innerHTML = `<div class="alert alert-success">Reply Send successfully!</div>`;
                } else {
                    replyMessage.innerHTML = `<div class="alert alert-danger">${data.message || 'Failed to send reply'}</div>`;
                }

                setTimeout(() => replyMessage.innerHTML = '', 3000);
            })
            .catch(err => {
                console.error(err);
                replyMessage.innerHTML = `<div class="alert alert-danger">An error occurred.</div>`;
                setTimeout(() => replyMessage.innerHTML = '', 3000);
            });
        });
    }

        const assignLinks = document.querySelectorAll('.assign-user');
        const msg = document.getElementById('assignMessage');

        assignLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const userId = this.getAttribute('data-id');
                const supportId = this.getAttribute('data-support-id');
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                
                    fetch("{{ route('support.assign', $support->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            assigned_to: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update Assigned To
                            document.getElementById('assignedUserName').textContent = data.assigned_user_name;

                            // Show success message
                            msg.textContent = 'Assigned successfully!';
                            msg.className = 'alert alert-success'; // green
                            msg.style.display = 'block';
                        } else {
                            // Show error message
                            msg.textContent = 'Failed to assign user!';
                            msg.className = 'alert alert-danger'; // red
                            msg.style.display = 'block';
                        }

                        // Hide message after 3 seconds
                        setTimeout(() => {
                            msg.style.display = 'none';
                        }, 3000);
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Show error message
                        msg.textContent = 'An error occurred while assigning the user!';
                        msg.className = 'alert alert-danger'; // red
                        msg.style.display = 'block';

                        setTimeout(() => {
                            msg.style.display = 'none';
                        }, 3000);
                    });
            });
        });


        document.getElementById('statusSelect').addEventListener('change', function() {
            const status = parseInt(this.value); // numeric key
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('support.updateStatus', $support->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        status
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {


                        // Show success message
                        msg.textContent = 'Status updated to ' + data.status_name;
                        msg.className = 'alert alert-success'; // green
                        msg.style.display = 'block';
                    } else {
                        // Show error message
                        msg.textContent = 'Failed to change status!';
                        msg.className = 'alert alert-danger'; // red
                        msg.style.display = 'block';
                    }
                    setTimeout(() => {
                        msg.style.display = 'none';
                    }, 3000);
                })
                .catch(err => console.error('Error:', err));
        });


    });
</script>