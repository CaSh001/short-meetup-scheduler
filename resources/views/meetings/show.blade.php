@extends('layouts.base')

@section('content')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var copyInviteBtn = document.getElementById('copy-invite-btn');
        var meetingId = {{$meeting->id}};
        var inviteLink = "{{ route('availabilities.create', ['meeting' => ':meetingId']) }}";
        inviteLink = inviteLink.replace(':meetingId', meetingId);

        copyInviteBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(inviteLink)
                .then(function() {
                    copyInviteBtn.textContent = 'Copied!';
                    setTimeout(function() {
                        copyInviteBtn.textContent = 'Copy Invite to Clipboard';
                    }, 2000);
                })
                .catch(function(error) {
                    console.error('Failed to copy invite link: ', error);
                });
        });
    });
</script>
  <div class="container py-3">
          <p> test </p>
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title">{{$meeting->name}}</h5>
            
    
            @auth
            @if (Auth::user()->id == $meeting->user->id)
              <p>You are the host of this meeting.</p>
              <button id="copy-invite-btn" class="btn btn-primary">Copy Invite to Clipboard</button>
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


        <div id="availability-calendar">
              <table class="availability-table">
              <thead>
                  <tr>
                      <th></th>
                      @foreach ($days as $day)
                      <th class="side-label">{{ $day }}</th>
                      @endforeach
                  </tr>
              </thead>
              <tbody>
                  @foreach ($hours as $hour)
                  <tr>
                      <td>{{ $hour }}</td>
                      @foreach ($days as $day)
                      @php
                        $availabilityClass = '';
                        $busyCount = $meeting->availabilities
                            ->where('day', $day)
                            ->where('hour', $hour)
                            ->where('availability', 'busy')
                            ->count();

                        $availableCount = $meeting->availabilities
                            ->where('day', $day)
                            ->where('hour', $hour)
                            ->where('availability', 'busy')
                            ->count();

                          if ($busyCount > 0) {
                            $availabilityClass = 'busy';
                          }
                            elseif ($availableCount > 0) {
                            $availabilityClass = 'available';
                            }
                      @endphp
                      <td data-day={{$day}} data-hour={{$hour}} class="availability-cell side-label {{$availabilityClass}}"></td>
                      @endforeach
                  </tr>
                  @endforeach
              </tbody>
          </table>
        </div>

        
        </div>
            </div>
  </div>
  
@endsection