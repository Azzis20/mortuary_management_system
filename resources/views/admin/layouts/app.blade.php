<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Mortuary System</title>

     <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
     <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-pagination.css') }}">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    @stack('styles')
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
                <h2>Peaceful Rest</h2>
                <p>Mortuary Management System</p>
            </div>
            

            <nav class="nav-menu">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
        </svg>
        <span>Dashboard</span>
    </a>
    
     <a href="{{ route('admin.booking.index') }}" class="nav-item {{ request()->routeIs('admin.booking*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        <span>Bookings</span>
    </a>
    
    <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
            <line x1="12" y1="22.08" x2="12" y2="12"></line>
        </svg>
        <span>Service Packages</span>
    </a>
    
    <!-- Deceased & Tracking Dropdown -->
    <!-- <a href="{{ route('admin.deceased') }}" 
    class="nav-item {{ request()->routeIs('admin.deceased') ? 'active' : '' }}">
        <div class="nav-item-content">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            <span>Deceased</span>
        </div>
    </a> -->


<!-- Schedule & Assignment Dropdown -->
<input type="checkbox" id="schedule-dropdown-toggle" class="schedule-dropdown-toggle">
<label for="schedule-dropdown-toggle" class="nav-item dropdown-label {{ request()->routeIs('admin.task.index*') || request()->routeIs('admin.retrieval*') || request()->routeIs('admin.assignments*')  ? 'active' : '' }}">
    <div class="nav-item-content">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
            <path d="M8 14h.01"></path>
            <path d="M12 14h.01"></path>
            <path d="M16 14h.01"></path>
        </svg>
        <span>Schedule & Assignment</span>
    </div>
    <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <polyline points="6 9 12 15 18 9"></polyline>
    </svg>
</label>
<div class="dropdown-menu schedule-menu">
    <a href="{{ route('admin.assignments.index') }}" class="nav-item sub-item {{ request()->routeIs('admin.assignments.index*',) ? 'active' : '' }}">
        <span>Task Schedule</span>
    </a>
    <a href="{{ route('admin.retrieval') }}" class="nav-item sub-item {{ request()->routeIs('admin.retrieval*',) ? 'active' : '' }}">
        <span>Retrieval Schedule</span> 
    </a>
    <a href="{{ route('admin.viewing.index') }}" class="nav-item sub-item {{ request()->routeIs('admin.viewing.index*') ? 'active' : '' }}">
        <span>Viewing Schedule</span> 
    </a>
    <a href="{{ route('admin.embalming.index') }}" class="nav-item sub-item {{ request()->routeIs('admin.embalming.index*') ? 'active' : '' }}">
        <span>Embalming Schedule</span> 
    </a>
</div>
    
    <a href="{{ route('admin.inventory') }}" class="nav-item {{ request()->routeIs('admin.inventory*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
            <line x1="12" y1="22.08" x2="12" y2="12"></line>
        </svg>
        <span>Inventory</span>
    </a>
    
    <a href="{{ route('admin.rooms') }}" class="nav-item {{ request()->routeIs('admin.rooms*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
        </svg>
        <span>Rooms</span>
    </a>
    
    <a href="{{ route('admin.employee') }}" class="nav-item {{ request()->routeIs('admin.employee*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg>
        <span>Staff</span>
    </a>
    
    <a href="{{ route('admin.bill') }}" class="nav-item {{ request()->routeIs('admin.bill*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
        </svg>
        <span>Billing</span>
    </a>
    
    <a href="{{ route('admin.client') }}" class="nav-item {{ request()->routeIs('admin.client*') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <span>Clients</span>
    </a>
    
    <!-- Trigger for modal -->
    <label for="logout-modal-toggle" class="nav-item logout-btn">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        <span>Logout</span>
    </label>
</nav>
            
            
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>@yield('page-title')</h1>
                <div class="user-info">
                    <span>{{ auth()->user()->name }}</span>
                    <span class="badge">{{ ucfirst(auth()->user()->accountType) }}</span>
                </div>
            </header>
            
            <div class="content">
                <div class="page-content">
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Logout Confirmation Modal (Pure CSS) -->
    <input type="checkbox" id="logout-modal-toggle" class="logout-modal-toggle">
    <div class="logout-modal">
        <label for="logout-modal-toggle" class="logout-modal-overlay"></label>
        <div class="logout-modal-content">
            <div class="logout-modal-header">Confirm Logout</div>
            <div class="logout-modal-body">
                Are you sure you want to logout?
            </div>
            <div class="logout-modal-actions">
                <label for="logout-modal-toggle" class="logout-modal-btn logout-modal-btn-cancel">Cancel</label>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-modal-btn logout-modal-btn-confirm">Logout</button>
                </form>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>