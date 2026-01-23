@extends('layouts.user_type.auth')

@section('content')

<h4 class="mb-4">Create Support Ticket</h4>

<form action="{{ route('support-store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Subject</label>
        <input type="text"
               name="subject"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-control" required>
            <option value="">-- Select Category --</option>
            @foreach($categories as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Assign To (Internal Staff)</label>
        <select name="assigned_to" class="form-control">
            <option value="">-- Unassigned --</option>
            @foreach($staffUsers as $user)
                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-control">
            @foreach(\App\Models\Support::priorities() as $id => $label)
                <option value="{{ $id }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea name="description"
                  rows="5"
                  class="form-control"
                  required></textarea>
    </div>

    <button class="btn btn-success">Create Ticket</button>
    <a href="{{ route('support') }}" class="btn btn-secondary">Cancel</a>
</form>

@endsection
