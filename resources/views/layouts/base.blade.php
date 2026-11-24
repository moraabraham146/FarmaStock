<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FarmaStock')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("{{ asset('img/fondo.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient mb-4">
        <div class="container">
            <a class="navbar-brand fs-3 fw-bold py-0" href="/">💊 FarmaStock</a>
            <ul class="navbar-nav ms-auto flex-row gap-3">
                <li class="nav-item"><a class="nav-link" href="/inventario">Almacén</a></li>
                <li class="nav-item"><a class="nav-link" href="/medicinas">Medicinas</a></li>
                <li class="nav-item"><a class="nav-link" href="/categorias">Categorías</a></li>
                <li class="nav-item"><a class="nav-link" href="/proveedores">Proveedores</a></li>
                <li class="nav-item"><a class="nav-link" href="/movimientos">Movimientos</a></li>
            </ul>
        </div>
    </nav>

    <main class="container flex-grow-1">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark bg-gradient text-white text-center py-3 mt-5">
        <div class="container">
            <small>&copy; {{ date('Y') }} FarmaStock · Sistema de inventario de medicinas</small>
        </div>
    </footer>

</body>
</html>