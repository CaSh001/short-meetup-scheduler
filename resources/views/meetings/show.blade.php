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


    function selectCell(cell) {
      if(cell.classList.contains('available')){
          var day = cell.getAttribute('data-day');
          var hour = cell.getAttribute('data-hour');
          var meetingId = {{$meeting->id}};

          // Send an AJAX request to update the "finalized time"
          var xhr = new XMLHttpRequest();
          xhr.open('PATCH', '{{ route("meetings.updateFinalizedTime", ["meeting" => $meeting->id]) }}', true);
          xhr.setRequestHeader('Content-Type', 'application/json');
          xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
          xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  // Handle the response or update the page if needed
                  console.log('Finalized time updated successfully');
                  location.reload(); // Reload the page
              }
          };

          var data = JSON.stringify({
              day: day,
              hour: hour,
              meetingId: meetingId
          });
          xhr.send(data);
      }
}

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
                @php
                  $allData = $meeting->availabilities()->pluck('availability_data');
                  $day = 'Monday';
                  $hour = '0';
                  $test = $allData->filter(function ($availability) use ($day, $hour) {
                              $availability = json_decode($availability, true);
                              return collect($availability)->contains(function ($item) use ($day, $hour) {
                                  return $item['day'] === $day && $item['hour'] === $hour && $item['availability'] === 'busy';
                              });
                          })->count();

                @endphp
                  @foreach ($hours as $hour)
                  <tr>
                      <td>{{ $hour }}</td>
                      @foreach ($days as $day)
                        @php
                          $availabilityClass = '';

                          $busyCount = $allData->filter(function ($availability) use ($day, $hour) {
                              $availability = json_decode($availability, true);
                              return collect($availability)->contains(function ($item) use ($day, $hour) {
                                  return $item['day'] == $day && $item['hour'] == $hour && $item['availability'] == 'busy';
                              });
                          })->count();

                          $availableCount = $allData->filter(function ($availability) use ($day, $hour) {
                              $availability = json_decode($availability, true);
                              return collect($availability)->contains(function ($item) use ($day, $hour) {
                                  return $item['day'] == $day && $item['hour'] == $hour && $item['availability'] == 'available';
                              });
                          })->count();

                            if ($busyCount > 0) {
                              $availabilityClass = 'busy';
                            }
                              elseif ($availableCount > 0) {
                              $availabilityClass = 'available';
                              }
                        @endphp
                      <td onclick="selectCell(this)" data-day={{$day}} data-hour={{$hour}} class="availability-cell side-label {{$availabilityClass}}
                      {{ explode(",", $meeting->finalized_time)[0] == $day && explode(",",$meeting->finalized_time)[1] == $hour ? 'final' : '';}}"></td>
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