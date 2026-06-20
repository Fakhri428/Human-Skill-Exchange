@php
    $statusTone = [
        'pending' => 'border-amber-200 bg-amber-50 text-amber-800',
        'accepted' => 'border-indigo-200 bg-indigo-50 text-indigo-800',
        'in_progress' => 'border-blue-200 bg-blue-50 text-blue-800',
        'completed' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        'reviewed' => 'border-slate-200 bg-slate-100 text-slate-700',
        'rejected' => 'border-rose-200 bg-rose-50 text-rose-800',
        'cancelled' => 'border-slate-200 bg-slate-50 text-slate-600',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Profil {{ $user->name }}
        </h2>
    </x-slot>

    <div class="bg-slate-50 py-8">
        <main class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <section class="rounded-lg border border-slate-200 bg-white p-6">
                <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
                    <div class="flex items-center gap-4">
                        <img class="h-20 w-20 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                        <div>
                            <p class="text-sm font-semibold text-teal-700">{{ $user->plan?->name ?? 'Gratis' }}</p>
                            <h1 class="mt-1 text-2xl font-semibold text-slate-950">{{ $user->name }}</h1>
                            <p class="mt-1 text-sm text-slate-600">{{ $user->profile?->bio ?? 'Bio tidak tersedia' }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $user->profile?->location ?? 'Lokasi tidak diisi' }} · {{ $user->profile?->work_mode ?? 'online' }}</p>
                        </div>
                    </div>

                    <div class="space-y-1 rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <div class="text-center">
                            <div class="text-2xl font-semibold text-slate-950">{{ $reputation['score'] }}</div>
                            <div class="text-xs font-semibold text-slate-500">Reputasi</div>
                        </div>
                        <hr class="my-2 border-slate-200">
                        <div class="grid grid-cols-3 gap-2 text-center text-xs">
                            <div>
                                <strong class="block text-sm text-slate-950">{{ $reputation['completed'] }}</strong>
                                <span class="text-slate-500">Selesai</span>
                            </div>
                            <div>
                                <strong class="block text-sm text-slate-950">{{ $reputation['average'] }}</strong>
                                <span class="text-slate-500">Rating</span>
                            </div>
                            <div>
                                <strong class="block text-sm text-slate-950">{{ $reputation['reviews'] }}</strong>
                                <span class="text-slate-500">Review</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($user->profile?->social_url || $user->profile?->portfolio_url)
                    <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-200 pt-6">
                        @if ($user->profile?->portfolio_url)
                            <a href="{{ $user->profile->portfolio_url }}" target="_blank" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50">
                                Portfolio Eksternal
                            </a>
                        @endif
                        @if ($user->profile?->social_url)
                            <a href="{{ $user->profile->social_url }}" target="_blank" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50">
                                Social Media
                            </a>
                        @endif
                    </div>
                @endif
            </section>

            <!-- Skill Section -->
            <section class="mt-6 rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-950">Skill</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($user->skills as $skill)
                        <div class="flex items-center justify-between px-6 py-4">
                            <div>
                                <p class="font-semibold text-slate-950">{{ $skill->name }}</p>
                                <p class="text-sm text-slate-500">{{ $skill->category }}</p>
                            </div>
                            <span class="rounded-md bg-teal-50 px-3 py-1 text-xs font-semibold capitalize text-teal-700">{{ $skill->level }}</span>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-sm text-slate-500">Belum ada skill yang ditambahkan.</div>
                    @endforelse
                </div>
            </section>

            <!-- Portfolio Gallery Section -->
            <section class="mt-6 rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-950">Portfolio</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($user->portfolios as $portfolio)
                        <article class="px-6 py-5">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-950">{{ $portfolio->title }}</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $portfolio->description }}</p>
                                    <div class="mt-3 flex flex-wrap gap-3 text-xs">
                                        @if ($portfolio->file_url)
                                            <a href="{{ $portfolio->file_url }}" target="_blank" class="font-semibold text-teal-700 hover:underline">Lihat file</a>
                                        @endif
                                        @if ($portfolio->project_url)
                                            <a href="{{ $portfolio->project_url }}" target="_blank" class="font-semibold text-teal-700 hover:underline">Lihat project</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="px-6 py-5 text-sm text-slate-500">Belum ada portfolio yang ditambahkan.</div>
                    @endforelse
                </div>
            </section>

            <!-- Offer Section -->
            <section class="mt-6 rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-950">Penawaran (Offer)</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($user->offers as $offer)
                        <a href="{{ route('offers.show', $offer) }}" class="block p-6 hover:bg-slate-50">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-950">{{ $offer->title }}</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $offer->description }}</p>
                                    <p class="mt-2 text-xs text-slate-500">{{ $offer->type ?? 'skill' }} · {{ $offer->available_duration ?? '—' }}</p>
                                </div>
                                <span class="shrink-0 rounded-md bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">{{ $offer->category }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-5 text-sm text-slate-500">Belum ada offer yang dibuat.</div>
                    @endforelse
                </div>
            </section>

            <!-- Need Section -->
            <section class="mt-6 rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-950">Kebutuhan (Need)</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($user->needs as $need)
                        <a href="{{ route('needs.show', $need) }}" class="block p-6 hover:bg-slate-50">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-950">{{ $need->title }}</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $need->description }}</p>
                                </div>
                                <span class="shrink-0 rounded-md bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">{{ $need->category }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-5 text-sm text-slate-500">Belum ada need yang dibuat.</div>
                    @endforelse
                </div>
            </section>

            @if ($viewer && (int) $viewer->id !== (int) $user->id)
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('market') }}" class="rounded-md border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-800 hover:bg-slate-50">
                        Kembali ke Market
                    </a>
                    <a href="{{ route('matches') }}" class="rounded-md bg-teal-600 px-4 py-3 text-sm font-semibold text-white hover:bg-teal-700">
                        Lihat Matches
                    </a>
                </div>
            @endif
        </main>
    </div>
</x-app-layout>
