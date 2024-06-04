<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Icono en navegador --}}
    <link rel="icon" type="image/png" href="{{ asset('icoCaja.ico') }}">

    <title>@yield('titulo')</title>


    {{-- Reinicio css --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<link rel="stylesheet" href="{{asset('assets/jquery-ui-1.13.3/jquery-ui.js')}}">

    {{-- Boostrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Css Header --}}
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    {{-- Css Footer --}}


    {{-- Otros css --}}
    @yield('css')

</head>

<body>

    {{-- Trae el  HEADER --}}
    @include('partials.header')


    {{-- Aqui se extiende cada vista --}}
    @yield('contenido')

    {{-- Trae el  HEADER --}}
    @include('partials.footer')


    {{-- Boostrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('assets/jquery.js')}}"></script>
    <script src="{{asset('assets/jquery-ui-1.13.3/jquery-ui.js')}}"></script>


    {{-- Otros Js --}}
    @yield('scrips')


</body>

</html>
