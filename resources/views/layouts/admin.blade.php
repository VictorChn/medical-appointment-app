@props([
        'title' => config('app.name', 'Laravel'),
        'breadcrumbs' => []
])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/48f9950399.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50">
        @include('layouts.includes.admin.navigation')
        @include('layouts.includes.admin.sidebar')

        <main class="p-4 sm:ml-64 mt-14">
            @include('layouts.includes.admin.breadcrumb')

@isset($action)
        <div class="flex justify-end mb-4">
          {{ $action }}
        </div>
      @endisset

            {{ $slot }}
        </main>

        @stack('modals')

        @if(session('swal'))
            <script>
                Swal.fire({
                    title: "{{ session('swal.title') }}",
                    text: "{{ session('swal.text') }}",
                    icon: "{{ session('swal.icon') }}",
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    </body>
</html>
</html>