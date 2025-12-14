
@extends('admin.layouts.app')
@section('title', 'Deceased Individual')

@section('page-title', 'Deceased Individual')

@section('content')
    <!-- <div class="card">
        <h3>Deceased Individual Management</h3>
        <p>Manage deceased individual records</p>
    </div> -->

    <div class="card">
        <form action="{{ route('admin.deceased.search') }}" method="GET" class="search-form">
            <div class="search-container">
                <input 
                    type="text" 
                    name="search" 
                    class="search-input" 
                    placeholder="Search by Deceased nane or Cuase of Death..." 
                    value="{{ request('search') }}"
                >
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
                <th>Name</th>
            
                <th>Gender</th>

                <th>Age</th>
            
                <th>Cause Of Death</th>

                <th>Action</th>
            
               
            </tr>
            
        </thead>
        
        <tbody>
            @if ($deceases->isEmpty())
            <tr>
                <td colspan="4" style="text-align: center;">No Decease Record found</td>
            </tr>
            @else
            
            @foreach ($deceases as $decease)
            <tr>
               
                 <td>{{ $decease->name ?? 'N/A' }}</td>

                
                <td>{{ $decease->gender ?? 'N/A' }}</td>


                <td>
                    @if ($decease->date_of_birth && $decease->date_of_death)
                        {{ (int)\Carbon\Carbon::parse($decease->date_of_birth)->diffInYears(\Carbon\Carbon::parse($decease->date_of_death)) }}
                    @else
                        N/A
                    @endif
                </td>
                                
                <td>{{ $decease->cause_of_death ?? 'N/A' }}</td>

                <td>
                    <a href="{{ route('admin.deceased.show', $decease->id) }}" class="btn btn-sm btn-primary" title="View Details">
                        <i class="fas fa-eye"></i> View
                    </a>
                </td>    

                
            </tr>
            @endforeach
            @endif

        </tbody>
    </table>
        <div>
               
        {{ $deceases->appends(request()->query())->links() }}
    

        </div>
    </div>
@endsection