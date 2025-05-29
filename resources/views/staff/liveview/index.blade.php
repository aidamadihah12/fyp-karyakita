@extends('layouts.admin') {{-- Reuse admin layout for identical styling --}}

@section('title', 'Live View')

@section('content')
    <h2 class="mb-4">Live Queue View</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('staff.liveview.reset') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-danger">Reset Queue</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Position</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($queue as $item)
                <tr>
                    <td>{{ $item->position }}</td>
                    <td>{{ $item->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Queue is empty.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        setInterval(() => {
            location.reload();
        }, 5000); // refresh every 5 seconds
    </script>
@endsection
