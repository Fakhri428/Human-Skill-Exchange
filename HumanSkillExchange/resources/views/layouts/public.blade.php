<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Human Skill Exchange' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="min-h-screen">
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-950 text-sm font-semibold text-white">HSE</span>
                    <span>
                        <span class="block text-sm font-semibold text-slate-950">Human Skill Exchange</span>
                        <span class="block text-xs text-slate-500">Barter skill antar manusia</span>
                    </span>
                </a>

                <nav class="flex flex-wrap items-center gap-1 text-sm">
                    <a href="{{ route('market') }}" class="rounded-md px-3 py-2 font-medium {{ request()->routeIs('home', 'market', 'preview', 'offers.show', 'needs.show') ? 'bg-slate-100 text-slate-950' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">Market</a>
                    <a href="{{ route('matches') }}" class="rounded-md px-3 py-2 font-medium {{ request()->routeIs('matches') ? 'bg-slate-100 text-slate-950' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">Match</a>
                    <a href="{{ route('docs') }}" class="rounded-md px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950">API Docs</a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-md bg-slate-950 px-3 py-2 font-semibold text-white hover:bg-slate-800">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md border border-slate-300 px-3 py-2 font-semibold text-slate-800 hover:bg-slate-100">Login</a>
                        <a href="{{ route('register') }}" class="rounded-md bg-teal-600 px-3 py-2 font-semibold text-white hover:bg-teal-700">Daftar</a>
                    @endauth
                </nav>
            </div>
        </header>

        {{ $slot }}
    </div>
</body>
</html>
