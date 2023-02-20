<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')

            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="src/img/icons/elektro.png">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.1/dist/cdn.min.js"></script>

        <link rel="stylesheet" href="/src/css/output.css">
        <link rel="stylesheet" href="/src/css/app.css">
        @livewireStyles
        @livewireScripts

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="antialiased dark:bg-dark">
       @yield('content')
        <x-footer/>
        
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        
            window.addEventListener('modal', event=> {
                Swal.fire({
                    position: 'center',
                    icon: event.detail.type,
                    title: event.detail.title,
                    showConfirmButton: true,
                    });
            });

            window.addEventListener('confirm', event=>{
                Swal.fire({
                    title: event.detail.title,
                    text: "Anda tidak bisa mengembalikan data ini!",
                    icon: event.detail.icon,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: event.detail.confirmButtonText,
                    cancelButtonText: 'Batal'
                })
                .then((result) => {
                    if(result.isConfirmed){
                        window.livewire.emit(event.detail.useMethod, event.detail.key);
                        console.log(event.detail.key);
                    }
                });
            });
        </script>

    </body>
</html>

