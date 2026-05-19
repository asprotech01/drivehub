<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DriveHub')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#1E3A8A', primaryHover: '#1e40af',
                        secondary: '#3B82F6', secondaryHover: '#2563EB',
                        dark: '#111827', light: '#F3F4F6',
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>

<body class="font-sans text-gray-800 bg-gray-50 pt-20 antialiased">

    <!-- Simplified Navbar for Checkout Flow -->
    <nav class="fixed top-0 w-full z-50 bg-white border-b border-gray-200 shadow-sm" id="navbar">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img class="h-10 w-auto" src="{{ asset('Assets/Logo/logo-dh.png') }}" alt="DriveHub Logo">
                    <span class="font-bold text-2xl text-primary tracking-tight">DriveHub</span>
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-dark hidden sm:inline">{{ Auth::user()->name }}</span>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
