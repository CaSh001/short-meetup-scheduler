@extends('layouts.base')

@section('content')
  <div class="container py-3">
          <p> test </p>
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title">{{$meeting->name}}</h5>
            
    
            @auth
            @if (Auth::user()->id == $meeting->user->id)
              <p>You are the host of this meeting.</p>
            @endif
          @endauth

          @if ($meeting->availabilities->count() > 0)
        <h4>Atendees:</h4>
        <ul>
            @foreach ($meeting->availabilities as $availability)
            <li>{{ $availability->name }}</li>
            @endforeach
        </ul>
        @else
        <p>So far no attendees have joined this meeting.</p>
        @endif

        
        </div>
            </div>
  </div>
  
@endsection