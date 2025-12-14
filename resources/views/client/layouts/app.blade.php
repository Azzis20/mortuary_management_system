<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Peaceful Rest Mortuary</title>
     <link rel="stylesheet" href="{{ asset('css/bootstrap-pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
   
    
    @stack('styles')
</head>
<body>
        
        <!-- Header -->
         <input type="checkbox" id="mobile-menu-toggle" class="mobile-menu-toggle">
        <header class="header">
            <div class="header-content">

                <div class="logo">Peaceful Rest Mortuary</div>
         
                <!-- Hamburger Menu Icon -->
                <label for="mobile-menu-toggle" class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                
                <nav>
                    <ul class="nav-menu">
                        <li><a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        
                        <li><a href="{{ route('client.decease.index') }}" class="nav-link {{ request()->routeIs('client.decease.*') ? 'active' : '' }}">My Deceased</a></li>
                        <!-- Services Dropdown -->

                        <li class="nav-dropdown">
                            <a href="#" class="nav-link {{ request()->routeIs('client.services.*','client.viewing.index') ? 'active' : '' }}">
                                Services <span class="dropdown-arrow">▼</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('client.services.index') }}" class="dropdown-item">Services</a></li>
                                <li><a href="{{ route('client.services.booking') }}" class="dropdown-item">My Bookings</a></li>
                                <li><a href="{{ route('client.viewing.index') }}" class="dropdown-item">Viewing</a></li>
                          


                            </ul>
                        </li>
                        <li><a href="{{ route('client.billing.index') }}" class="nav-link {{ request()->routeIs('client.billing.*') ? 'active' : '' }}">Billing</a></li>
                    </ul>
                </nav>

            <div class="user-section">
    
                <a href="{{ route('client.profile.index') }}" 
                style="text-decoration: none; display: flex; align-items: center; gap: 0.75rem;">
                    
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; border: 1px solid #e2e8f0; background: #f7fafc; display: flex; align-items: center; justify-content: center;">
                            @if(auth()->user()->profile->picture)
                                <img src="{{ asset(auth()->user()->profile->picture) }}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <svg style="width: 24px; height: 24px; color: #cbd5e0;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                    
                    <span style="color: #121212; font-weight: 600; font-size: 16px;">{{ auth()->user()->name }}</span>
                    
                </a>
                
                <label for="logout-modal-toggle" class="logout-btn">Logout</label>
            </div>
    

            </div>
        </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Logout Confirmation Modal -->
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