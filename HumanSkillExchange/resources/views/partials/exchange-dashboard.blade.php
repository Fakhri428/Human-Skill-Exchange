@php
    $embedded = $embedded ?? false;
    $initials = function (?string $name) {
        $name = trim((string) $name);
        if ($name === '') {
            return 'HS';
        }

        $parts = preg_split('/\s+/', $name);
        return strtoupper(substr($parts[0] ?? 'H', 0, 1).substr($parts[1] ?? $parts[0] ?? 'S', 0, 1));
    };
    $metricTone = [
        'teal' => 'border-teal-200 bg-teal-50 text-teal-900',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-900',
        'rose' => 'border-rose-200 bg-rose-50 text-rose-900',
        'indigo' => 'border-indigo-200 bg-indigo-50 text-indigo-900',
    ];
    $statusTone = [
        'suggested' => 'bg-teal-50 text-teal-800 border-teal-200',
        'draft' => 'bg-amber-50 text-amber-800 border-amber-200',
        'pending' => 'bg-amber-50 text-amber-800 border-amber-200',
        'accepted' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
        'in_progress' => 'bg-blue-50 text-blue-800 border-blue-200',
        'completed' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
        'reviewed' => 'bg-slate-100 text-slate-700 border-slate-200',
    ];
@endphp

<div class="{{ $embedded ? 'bg-slate-50' : 'min-h-screen bg-slate-50' }}">
    @unless ($embedded)
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-900 text-sm font-semibold text-white">HSE</span>
                    <span>
                        <span class="block text-sm font-semibold text-slate-950">Human Skill Exchange</span>
                        <span class="block text-xs text-slate-500">Skill barter workspace</span>
                    </span>
                </a>

                <nav class="flex flex-wrap items-center gap-2 text-sm">
                    <a href="#market" class="rounded-md px-3 py-2 text-slate-600 hover:bg-slate-100 hover:text-slate-950">Market</a>
                    <a href="#match" class="rounded-md px-3 py-2 text-slate-600 hover:bg-slate-100 hover:text-slate-950">Match</a>
                    <a href="{{ route('docs') }}" class="rounded-md px-3 py-2 text-slate-600 hover:bg-slate-100 hover:text-slate-950">API Docs</a>
                    <a href="{{ route('login') }}" class="rounded-md border border-slate-300 px-3 py-2 font-medium text-slate-800 hover:bg-slate-100">Login</a>
                </nav>
            </div>
        </header>
    @endunless

    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <section class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-6">
                <div class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="max-w-2xl">
                            <p class="text-sm font-medium text-teal-700">Preview aplikasi</p>
                            <h1 class="mt-2 text-3xl font-semibold text-slate-950 sm:text-4xl">Dashboard pertukaran skill</h1>
                            <p class="mt-3 text-sm leading-6 text-slate-600">
                                User bisa menampilkan profil, mencari offer, mencatat need, menerima rekomendasi match, lalu menjalankan exchange sampai review.
                            </p>
                        </div>

                        <div class="grid min-w-0 grid-cols-2 gap-2 sm:min-w-[260px]">
                            @foreach ($metrics as $metric)
                                <div class="rounded-lg border p-3 {{ $metricTone[$metric['tone']] ?? 'border-slate-200 bg-slate-50 text-slate-900' }}">
                                    <div class="text-2xl font-semibold">{{ $metric['value'] }}</div>
                                    <div class="mt-1 text-xs font-medium">{{ $metric['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <section id="market" class="grid gap-6 xl:grid-cols-2">
                    <div class="rounded-lg border border-slate-200 bg-white">
                        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                            <div>
                                <h2 class="text-base font-semibold text-slate-950">Offer terbaru</h2>
                                <p class="mt-1 text-xs text-slate-500">Kontribusi yang bisa ditukar.</p>
                            </div>
                            <a href="{{ url('/api/offers') }}" class="rounded-md border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">JSON</a>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @forelse ($offers as $offer)
                                <article class="p-5">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-teal-100 text-sm font-semibold text-teal-900">
                                            {{ $initials($offer->user?->name) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h3 class="text-sm font-semibold text-slate-950">{{ $offer->title }}</h3>
                                                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">{{ $offer->type }}</span>
                                            </div>
                                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $offer->description }}</p>
                                            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                                <span class="rounded-md border border-slate-200 px-2 py-1 text-slate-600">{{ $offer->category }}</span>
                                                <span class="rounded-md border border-slate-200 px-2 py-1 text-slate-600">{{ $offer->available_duration ?? 'Fleksibel' }}</span>
                                                <span class="rounded-md border border-slate-200 px-2 py-1 text-slate-600">{{ $offer->user?->profile?->work_mode ?? 'online' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="p-5 text-sm text-slate-500">Belum ada offer.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white">
                        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                            <div>
                                <h2 class="text-base font-semibold text-slate-950">Need terbuka</h2>
                                <p class="mt-1 text-xs text-slate-500">Kebutuhan bantuan dari user.</p>
                            </div>
                            <a href="{{ url('/api/needs') }}" class="rounded-md border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">JSON</a>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @forelse ($needs as $need)
                                <article class="p-5">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-100 text-sm font-semibold text-rose-900">
                                            {{ $initials($need->user?->name) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h3 class="text-sm font-semibold text-slate-950">{{ $need->title }}</h3>
                                                <span class="rounded-md bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700">{{ $need->category }}</span>
                                            </div>
                                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $need->description }}</p>
                                            <p class="mt-3 text-xs leading-5 text-slate-500">Barter: {{ $need->exchange_offer }}</p>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="p-5 text-sm text-slate-500">Belum ada need.</div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-base font-semibold text-slate-950">Alur exchange</h2>
                        <p class="mt-1 text-xs text-slate-500">Gambaran status yang akan dilalui user.</p>
                    </div>
                    <div class="grid gap-3 p-5 md:grid-cols-4">
                        @foreach ([
                            ['title' => 'Request', 'copy' => 'Pilih offer dan need, lalu kirim pesan ke partner.', 'tone' => 'border-teal-200 bg-teal-50'],
                            ['title' => 'Accept', 'copy' => 'Partner menerima atau menolak request exchange.', 'tone' => 'border-amber-200 bg-amber-50'],
                            ['title' => 'Progress', 'copy' => 'Kedua user mencatat perkembangan dan file pendukung.', 'tone' => 'border-indigo-200 bg-indigo-50'],
                            ['title' => 'Review', 'copy' => 'Exchange selesai setelah dua pihak konfirmasi dan memberi rating.', 'tone' => 'border-rose-200 bg-rose-50'],
                        ] as $step)
                            <article class="rounded-lg border p-4 {{ $step['tone'] }}">
                                <h3 class="text-sm font-semibold text-slate-950">{{ $step['title'] }}</h3>
                                <p class="mt-2 text-xs leading-5 text-slate-600">{{ $step['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>

            <aside class="space-y-6">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-900 text-sm font-semibold text-white">
                            {{ $initials($viewer?->name) }}
                        </div>
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold text-slate-950">{{ $viewer?->name ?? 'Guest User' }}</h2>
                            <p class="truncate text-sm text-slate-500">{{ $viewer?->email ?? 'guest@example.com' }}</p>
                        </div>
                    </div>

                    <p class="mt-4 text-sm leading-6 text-slate-600">
                        {{ $viewer?->profile?->bio ?? 'Profil user akan menampilkan personal branding, lokasi, mode kerja, dan ketersediaan waktu.' }}
                    </p>

                    <div class="mt-4 grid grid-cols-2 gap-2 text-xs">
                        <div class="rounded-lg border border-slate-200 p-3">
                            <span class="block text-slate-500">Plan</span>
                            <strong class="mt-1 block text-slate-950">{{ $viewer?->plan?->name ?? 'Gratis' }}</strong>
                        </div>
                        <div class="rounded-lg border border-slate-200 p-3">
                            <span class="block text-slate-500">Mode</span>
                            <strong class="mt-1 block text-slate-950">{{ $viewer?->profile?->work_mode ?? 'online' }}</strong>
                        </div>
                    </div>

                    @if ($planUsage)
                        <div class="mt-5 space-y-3">
                            @foreach ($planUsage as $usage)
                                @php
                                    $max = $usage['max'];
                                    $percent = $max ? min(100, (int) round(($usage['used'] / $max) * 100)) : 100;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-xs text-slate-500">
                                        <span>{{ $usage['label'] }}</span>
                                        <span>{{ $usage['used'] }} / {{ $max ?? '∞' }}</span>
                                    </div>
                                    <div class="mt-2 h-2 rounded-full bg-slate-100">
                                        <div class="h-2 rounded-full bg-teal-600" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section id="match" class="rounded-lg border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-base font-semibold text-slate-950">Rekomendasi match</h2>
                        <p class="mt-1 text-xs text-slate-500">Berdasarkan offer, need, kategori, dan profil.</p>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($recommendations as $item)
                            <article class="p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-900">
                                            {{ $initials($item['user']->name) }}
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="truncate text-sm font-semibold text-slate-950">{{ $item['user']->name }}</h3>
                                            <p class="truncate text-xs text-slate-500">{{ $item['label'] }}</p>
                                        </div>
                                    </div>
                                    <span class="rounded-md bg-teal-50 px-2 py-1 text-xs font-semibold text-teal-700">{{ $item['score'] }}%</span>
                                </div>
                                <p class="mt-3 text-xs leading-5 text-slate-600">{{ $item['reason'] }}</p>
                                <a href="{{ url('/api/matches') }}" class="mt-4 inline-flex rounded-md bg-slate-900 px-3 py-2 text-xs font-medium text-white hover:bg-slate-700">Lihat API match</a>
                            </article>
                        @empty
                            <div class="p-5 text-sm text-slate-500">Belum ada rekomendasi.</div>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-base font-semibold text-slate-950">Reputasi</h2>
                            <p class="mt-1 text-xs text-slate-500">Ringkasan trust user.</p>
                        </div>
                        <div class="rounded-lg bg-slate-900 px-3 py-2 text-xl font-semibold text-white">{{ $reputation['score'] }}</div>
                    </div>
                    <div class="mt-5 grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="rounded-lg border border-slate-200 p-3">
                            <strong class="block text-sm text-slate-950">{{ $reputation['completed'] }}</strong>
                            <span class="text-slate-500">Selesai</span>
                        </div>
                        <div class="rounded-lg border border-slate-200 p-3">
                            <strong class="block text-sm text-slate-950">{{ $reputation['average'] }}</strong>
                            <span class="text-slate-500">Rating</span>
                        </div>
                        <div class="rounded-lg border border-slate-200 p-3">
                            <strong class="block text-sm text-slate-950">{{ $reputation['reviews'] }}</strong>
                            <span class="text-slate-500">Review</span>
                        </div>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-base font-semibold text-slate-950">Aktivitas exchange</h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach ($activity as $activityItem)
                            <article class="p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-sm font-semibold text-slate-950">{{ $activityItem['title'] }}</h3>
                                        <p class="mt-1 text-xs leading-5 text-slate-600">{{ $activityItem['description'] }}</p>
                                    </div>
                                    <span class="shrink-0 rounded-md border px-2 py-1 text-xs font-medium {{ $statusTone[$activityItem['status']] ?? 'border-slate-200 bg-slate-50 text-slate-700' }}">
                                        {{ str_replace('_', ' ', $activityItem['status']) }}
                                    </span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </aside>
        </section>
    </main>
</div>
