
@extends('admin.layouts.app')

@section('title', 'Retrieval')

@section('page-title', 'Retrieval Management')

@section('content')
    <div class="card">
        <h3>Retrieval Schedule Management</h3>
        <p>Manage Retrieval  Schedules</p>
    </div>



    <div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Deceased</th>
            
                <th>Location</th>
            
                <th>Schedule</th>
            
                <th>Status</th>

                <th>Staff In-charge</th>
            </tr>
            
        </thead>
        
        <tbody>
            @if ($bookServices->isEmpty())
            <tr>
                <td colspan="4" style="text-align: center;">No Retrieval Schedule found</td>
            </tr>
            @else
            
            @foreach ($bookServices as $service)
            <tr>
                {{-- Accessing the deceased name via the relationship --}}
                 <td>{{ $service->deceased->name ?? 'N/A' }}</td>

                {{-- Accessing retrieval data via the relationship --}}
                <td>{{ $service->bodyretrieval->location ?? 'N/A' }}</td>

                 
                <td>{{ $service->bodyretrieval->retrieval_schedule ?? 'N/A' }}</td>

                <td>{{ $service->status ?? 'N/A' }}</td>

                <td>
                    @if($service->tasks->isNotEmpty())
                        @foreach($service->tasks as $task)
                            {{ $task->staff->name ?? 'N/A' }}<br>
                        @endforeach
                    @else
                        N/A
                    @endif
                </td>
                

            </tr>
            @endforeach
            @endif

        </tbody>
    </table>
</div>

@endsection