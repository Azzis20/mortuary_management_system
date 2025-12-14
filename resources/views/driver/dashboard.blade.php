<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <nav class="bg-blue-600 text-white p-4 shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Driver Dashboard</h1>
                <div class="flex items-center gap-4">
                    <span>{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mx-auto p-6">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">Welcome, Driver!</h2>
                <p class="text-gray-600 mb-4">This is your driver dashboard. You can manage deliveries and tasks here.</p>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-900">Pending Deliveries</h3>
                        <p class="text-3xl font-bold text-blue-600">0</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-green-900">Completed Today</h3>
                        <p class="text-3xl font-bold text-green-600">0</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-purple-900">Total Deliveries</h3>
                        <p class="text-3xl font-bold text-purple-600">0</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-4">
                    <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        View Deliveries
                    </a>
                    <a href="#" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700">
                        My Schedule
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>