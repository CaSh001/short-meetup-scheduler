@extends('layouts.base')

@section('content')

    <div class="jumbotron">
      <h1 class="display-4">Short Meetup Scheduler</h1>
      <p class="lead">Create and schedule meetings!</p>
      <p class="lead">In this application, there are:</p>
      <p class="lead">{{ $numberOfUsers }} users,</p>
      <p class="lead">{{ $numberOfMeetings }} meetings,</p>
      <hr class="my-4">
    </div>


@endsection