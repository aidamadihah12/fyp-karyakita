@extends('layouts.admin')

@section('title', 'System Testing')

@section('content')
    <h2 class="mb-4">System Testing</h2>

    <form method="POST" action="{{ route('admin.system.testing.run') }}">
        @csrf
        <button type="submit" class="btn btn-primary mb-3">Run System Tests</button>
    </form>

    @if(session('testResults'))
        <h4>Test Results:</h4>
        <pre style="background:#f8f9fa; padding:15px; border:1px solid #ddd;">
{{ session('testResults') }}
        </pre>
    @endif
@endsection
