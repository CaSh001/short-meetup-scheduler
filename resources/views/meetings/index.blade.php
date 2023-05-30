@extends('layouts.base')

@section('content')
    <div class="container py-3">
        <h2>My Meetings</h2>

        <div class="row">
            @forelse ($meetings as $meeting)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $meeting->name }}</h5>
                            <p>Finalized Time: {{ $meeting->finalized_time ?? 'Not finalized yet' }}</p>
                            <p>Guests: {{ $meeting->availabilities_count }}</p>
                            <a href="{{ route('meetings.show', ['meeting' => $meeting->id]) }}" class="btn btn-primary">View Meeting</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No meetings found.</p>
            @endforelse
        </div>
    </div>
@endsection