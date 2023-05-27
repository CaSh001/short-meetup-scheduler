@extends('layouts.base')

@section('content')
  <div class="container py-3">
          <p> test </p>
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title">{{$meeting->name}}</h5>
                <p class="card-text"><small>Put more meeting details here</small></p>
              </div>
            </div>
            
    
            @auth
            @if (Auth::user()->id == $meeting->user->id)
              <p>You are the host of this meeting.</p>
            @endif
          @endauth
  </div>
  
@endsection