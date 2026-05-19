<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DriveHub')</title>

    <!-- Fonts -->
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
</head>
<body class="font-sans text-gray-800 bg-gray-50 flex items-center justify-center min-h-screen py-10 px-4 antialiased">

    @if(session('success'))
        <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 bg-green-50 border border-green-200 text-green-700 px-6 py-3 rounded-xl flex items-center gap-2 shadow-lg">
            <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 bg-red-50 border border-red-200 text-red-700 px-6 py-3 rounded-xl flex items-center gap-2 shadow-lg">
            <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
        </div>
    @endif

    @yield('content')

</body>
</html>
