




@extends('layouts.user_type.auth')

@section('content')


<div class="container-fluid py-4">

    <h4 class="mb-3">Notification Details</h4>

    <div class="card shadow-sm">
    <div class="card-body">

        <form method="POST"
      action="{{ route('push.notice.update', $notification->id) }}">
    @csrf

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title"
               class="form-control"
               value="{{ $notification->title }}">
    </div>

    <div class="mb-3">
        <label>Message</label>
        <textarea name="message"
                  class="form-control"
                  rows="5">{{ $notification->message }}</textarea>
    </div>

    <div class="mb-3">
        <label>Target Audience</label>
        <select name="role_id" class="form-select">
            @foreach($targetAudiences as $id => $label)
                <option value="{{ $id }}"
                    {{ $notification->role_id == $id ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">
        Update Draft
    </button>

    
</form>

    </div>
    </div>
</div>



    

@endsection