@extends('layouts.base')

@section('content')
<script>

let selectedCells = [];

function toggleAvailability(cell) {

    const day = cell.getAttribute('data-day');
    const hour = cell.getAttribute('data-hour');
    const availability = cell.classList.contains('available') ? 'available' : cell.classList.contains('busy') ? 'busy': null;


    const cellData = { day, hour, availability };
    const index = selectedCells.findIndex((c) => c.day === day && c.hour === hour);

    if (index !== -1) {
        selectedCells.splice(index, 1);
    }

    if (availability !== null) {
        selectedCells.push(cellData);
    }

    updateHiddenInput();
}

function updateHiddenInput() {
    const hiddenInput = document.getElementById('availabilityData');
    hiddenInput.value = JSON.stringify(selectedCells);
}

    document.addEventListener('DOMContentLoaded', function () {
        const cells = document.querySelectorAll('.availability-cell');
        const selectedCells = [];

        let isLeftMouseDown = false;
        let isRightMouseDown = false;

        function handleCellClick(cell, isLeftClick) {
            if (isLeftClick) {
                cell.classList.remove('busy');
                cell.classList.toggle('available');
            } else {
                cell.classList.remove('available');
                cell.classList.toggle('busy');
            }

            toggleAvailability(cell);
        }

        cells.forEach(function (cell) {
            cell.addEventListener('mousedown', function (event) {
                if (event.button === 0) {
                    isLeftMouseDown = true;
                    handleCellClick(cell, true);
                } else if (event.button === 2) {
                    isRightMouseDown = true;
                    handleCellClick(cell, false);
                }
            });

            cell.addEventListener('mouseenter', function (event) {
                if (isLeftMouseDown) {
                    handleCellClick(cell, true);
                } else if (isRightMouseDown) {
                    handleCellClick(cell, false);
                }
            });

            cell.addEventListener('mouseup', function (event) {
                if (event.button === 0) {
                    isLeftMouseDown = false;
                } else if (event.button === 2) {
                    isRightMouseDown = false;
                }
            });

            
            cell.addEventListener('contextmenu', function(event) {
                    event.preventDefault();
                });
        });
    });
</script>


    <div class="container py-3">
      <h2>Submit your availability for this meeting</h2>
      <form action="{{ route('availabilities.store', ['meeting' => $meetingId]) }}" method="POST">
        {{-- HTTP: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS,  --}}
        @csrf
        
        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" type="text" required class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Your name..."
            value="{{ old('name', '') }}">
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Create availability</button>
        </div>


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
                      <td data-day={{$day}} data-hour={{$hour}} class="availability-cell side-label"></td>
                      @endforeach
                  </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
        <input type="hidden" name="availability_data" id="availabilityData">

      </form>
    </div>

@endsection