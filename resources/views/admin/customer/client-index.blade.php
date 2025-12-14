@extends('admin.layouts.app')

@section('title', 'Client')

@section('page-title', 'Client management')

@section('content')
    <div class="card">
        <h3>Client management</h3>
        <p>Manage Client</p>
    </div>

    <div class="card">
        <form action="{{ route('admin.client.search') }}" method="GET" class="search-form">
            <div class="search-container">
                <input
                    type="text"

                    name="search" 
                    class="search-input" 
                    placeholder="Search by Name, ID, Email..." 
                    value="{{ request('search') }}" >
                <button type="submit" class="btn search-btn">
                    <i class="fa fa-search"> </i> Search 
                </button>
            </div>
        </form>
    </div>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    
                    </tr>
                </thead>
                
                <tbody>
                    @if ($clients->isEmpty())
                        <tr>
                            <td colspan="6" style="text-align: center;">
                                @if(request('search'))
                                    No results found for "{{ request('search') }}"
                                @else
                                    No Result
                                @endif
                            </td>
                        </tr>
                    @else
                        @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client-> id ?? 'N/A' }}</td>
                            <td>{{ $client-> name ?? 'N/A' }}</td>
                            <td>{{ $client-> email ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.client.show', $client->id) }}" class="btn btn-sm btn-primary" title="View Details">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        
        <div>
            {{ $clients->appends(request()->query())->links() }}
        </div>
    </div>
@endsection