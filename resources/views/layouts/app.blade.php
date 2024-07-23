<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name', 'Laris Mart')}}</title>
    @vite(['resources/sass/app.scss','resources/js/app.js'])
    <style>
        body {
            display: flex;
        }
        .sidebar {
            flex: 0 0 250px;
            background-color: #f8f9fa;
            height: 100vh;
            padding: 1rem;
            border-right: 1px solid #ddd;
        }
        .content {
            flex: 1;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Laris Mart</h1>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('items.index') }}">Daftar Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Transaksi</a>
            </li>
            <!-- Tambahkan link menu lainnya di sini -->
        </ul>
    </div>
    <div id="app" class="content">
        @yield('content')
    </div>
</body>
</html>