@php
    $metricTone = [
        'teal' => 'border-teal-200 bg-teal-50 text-teal-950',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-950',
        'indigo' => 'border-indigo-200 bg-indigo-50 text-indigo-950',
        'rose' => 'border-rose-200 bg-rose-50 text-rose-950',
    ];
@endphp

@component('layouts.public', ['title' => 'Human Skill Exchange'])
    <main>
        <section class="border-b border-slate-200 bg-white">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[minmax(0,1fr)_380px] lg:px-8">
                <div class="flex flex-col justify-center">
                    <p class="text-sm font-semibold text-teal-700">Skill market</p>
                    <h1 class="mt-3 max-w-3xl text-3xl font-semibold tracking-normal text-slate-950 sm:text-5xl">
                        Cari partner untuk barter skill, project, dan mentoring.
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">
                        Temukan orang yang bisa membantu kebutuhanmu, lalu tukarkan dengan keahlian yang kamu punya.
                    </p>

                    <form method="GET" action="{{ route('market') }}" class="mt-6 grid gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3 sm:grid-cols-[minmax(0,1fr)_220px_auto]">
                        <label class="sr-only" for="q">Cari skill</label>
                        <input
                            id="q"
                            name="q"
                            value="{{ $filters['q'] }}"
                            type="search"
                            placeholder="Cari Laravel, Figma, copywriting..."
                            class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500"
                        >

                        <label class="sr-only" for="category">Kategori</label>
                        <select id="category" name="category" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Semua kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @selected($filters['category'] === $category)>{{ $category }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                            Cari
                        </button>
                    </form>
                </div>

                <aside class="rounded-lg border border-slate-200 bg-slate-950 p-5 text-white">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-teal-200">Match tercepat</p>
                            <h2 class="mt-2 text-2xl font-semibold">Barter dua arah</h2>
                        </div>
                        <span class="rounded-md bg-teal-400/15 px-3 py-2 text-sm font-semibold text-teal-100">{{ count($recommendations) }} match</span>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse ($recommendations as $item)
                            <a href="{{ route('matches') }}" class="block rounded-lg border border-white/10 bg-white/5 p-4 hover:bg-white/10">
                                <div class="flex items-center gap-3">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $item['user']->profile_photo_url }}" alt="{{ $item['user']->name }}">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-semibold">{{ $item['user']->name }}</p>
                                        <p class="truncate text-xs text-slate-300">{{ $item['label'] }}</p>
                                    </div>
                                    <span class="text-sm font-semibold text-teal-200">{{ $item['score'] }}%</span>
                                </div>
                            </a>
                        @empty
                            <div class="rounded-lg border border-white/10 bg-white/5 p-4 text-sm text-slate-300">
                                Match akan muncul setelah member menambahkan offer dan need.
                            </div>
                        @endforelse
                    </div>
                </aside>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($stats as $stat)
                    <div class="rounded-lg border p-4 {{ $metricTone[$stat['tone']] ?? 'border-slate-200 bg-white text-slate-950' }}">
                        <div class="text-2xl font-semibold">{{ $stat['value'] }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-normal">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mx-auto grid max-w-7xl gap-6 px-4 pb-10 sm:px-6 lg:grid-cols-[minmax(0,1fr)_380px] lg:px-8">
            <div class="space-y-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-950">Offer yang bisa ditukar</h2>
                        <p class="mt-1 text-sm text-slate-500">Pilih kontribusi dari member lain dan mulai exchange.</p>
                    </div>
                    <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="inline-flex items-center justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
                        Buat offer
                    </a>
                </div>

                <div class="grid gap-4 xl:grid-cols-2">
                    @forelse ($offers as $offer)
                        <article class="rounded-lg border border-slate-200 bg-white p-5">
                            <div class="flex items-start gap-3">
                                <img class="h-11 w-11 rounded-full object-cover" src="{{ $offer->user->profile_photo_url }}" alt="{{ $offer->user->name }}">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('offers.show', $offer) }}" class="text-base font-semibold text-slate-950 hover:text-teal-700">
                                            {{ $offer->title }}
                                        </a>
                                        <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600">{{ $offer->category }}</span>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">{{ $offer->user->name }} · {{ $offer->user->profile?->location ?? 'Lokasi fleksibel' }} · {{ $offer->user->profile?->work_mode ?? 'online' }}</p>
                                </div>
                            </div>

                            <p class="mt-4 text-sm leading-6 text-slate-600">{{ $offer->description }}</p>
                            <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-normal text-slate-500">Ekspektasi barter</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">{{ $offer->exchange_expectation }}</p>
                            </div>

                            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                                <span class="rounded-md border border-slate-200 px-2 py-1 text-xs font-medium text-slate-600">{{ $offer->available_duration ?? 'Fleksibel' }}</span>
                                <a href="{{ route('offers.show', $offer) }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50">Detail</a>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-500 xl:col-span-2">
                            Belum ada offer yang cocok dengan filter saat ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <aside class="space-y-6">
                <section class="rounded-lg border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="text-base font-semibold text-slate-950">Need terbuka</h2>
                        <p class="mt-1 text-sm text-slate-500">Permintaan bantuan dari member.</p>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($needs->take(5) as $need)
                            <article class="p-5">
                                <div class="flex gap-3">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $need->user->profile_photo_url }}" alt="{{ $need->user->name }}">
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('needs.show', $need) }}" class="font-semibold text-slate-950 hover:text-teal-700">{{ $need->title }}</a>
                                        <p class="mt-1 text-xs text-slate-500">{{ $need->category }} · {{ $need->user->name }}</p>
                                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $need->description }}</p>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="p-5 text-sm text-slate-500">Belum ada need yang cocok.</div>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h2 class="text-base font-semibold text-slate-950">Member aktif</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($people as $person)
                            <div class="flex items-center gap-3">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $person->profile_photo_url }}" alt="{{ $person->name }}">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold text-slate-950">{{ $person->name }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ $person->profile?->bio ?? 'Member Human Skill Exchange' }}</p>
                                </div>
                                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600">{{ $person->skills->count() }} skill</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h2 class="text-base font-semibold text-slate-950">Plan member</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($plans as $plan)
                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-950">{{ $plan->name }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $plan->max_exchange_requests ? $plan->max_exchange_requests.' request/bulan' : 'Request tanpa batas' }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-teal-700">Rp{{ number_format($plan->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </aside>
        </section>
    </main>
@endcomponent
