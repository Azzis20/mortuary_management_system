@extends('admin.layouts.app')
@section('title', 'Staff Management')

@section('page-title', 'Employee Management')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Employee Management</h3>
            <a href="{{ route('admin.employee.create') }}" class="btn btn-primary">Add Employee</a>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('admin.employee.search') }}" method="GET" class="search-form">
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
                    <th>Account ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                  
                   
                </tr>
            </thead>
            
            <tbody>
                @if ($employees->isEmpty())
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
                    @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->id ?? 'N/A' }}</td>
                        <td>{{ $employee->name ?? 'N/A' }}</td>
                        <td>{{ $employee->email ?? 'N/A' }}</td>
                        <td>{{ $employee->accountType ?? 'N/A' }}</td>
                        
                        
                        <td>
                            <a href="{{ route('admin.employee.show', $employee->id) }}" class="btn btn-sm btn-primary" title="View Details"> 
                                 <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        
        <div>
            {{ $employees->appends(request()->query())->links() }}
        </div>
    </div>
@endsection