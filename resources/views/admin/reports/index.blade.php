@extends('layouts.admin')

@section('title', 'Reports - Studio Karya Kita')

@section('content')
    <div class="container">
        <h2 class="mb-4">Reports</h2>

        <p>This is the Reports page. You can add report generation features here.</p>

        {{-- Example report table with dynamic data --}}
        <div class="card shadow mt-4">
            <div class="card-header">
                <h5>Report Summary for Current Month</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Report ID</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>{{ $report['id'] }}</td>
                                <td>{{ $report['description'] }}</td>
                                <td>{{ $report['date'] }}</td>
                                <td>{{ $report['value'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
