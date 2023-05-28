@extends('layouts.base')

@section('content')
    <div class="container py-3">
      <h2>Submit your availability for this meeting</h2>
      <form action="{{ route('availabilities.store') }}" method="POST">
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

      </form>
    </div>

@endsection