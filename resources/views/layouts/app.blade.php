<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'My Laravel App' }}</title>
    <!-- Tambahkan CSS dan script lain sesuai kebutuhan -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>

<body class="font-sans antialiased">

    <header>
        <nav>
            <!-- Contoh menu -->
            <a href="{{ route('dashboard') }}">Dashboard</a> |
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

</body>

</html>
