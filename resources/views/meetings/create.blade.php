@extends('layouts.base')

@section('content')
    <div class="container py-3">
      <h2>New meeting</h2>
      <form action="{{ route('meetings.store') }}" method="POST">
        {{-- HTTP: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS,  --}}
        @csrf
        
        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" type="text" required class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Meeting name..."
            value="{{ old('name', '') }}">
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Create meeting</button>
        </div>

      </form>
    </div>

@endsection