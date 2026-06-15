@component('layouts.public', ['title' => 'Match - Human Skill Exchange'])
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <section class="grid gap-6 lg:grid-cols-[360px_minmax(0,1fr)]">
            <aside class="space-y-6">
                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex items-center gap-3">
                        @if ($viewer)
                            <img class="h-14 w-14 rounded-full object-cover" src="{{ $viewer->profile_photo_url }}" alt="{{ $viewer->name }}">
                        @else
                            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-950 text-sm font-semibold text-white">HS</div>
                        @endif
                        <div class="min-w-0">
                            <h1 class="truncate text-xl font-semibold text-slate-950">{{ $viewer?->name ?? 'Guest User' }}</h1>
                            <p class="truncate text-sm text-slate-500">{{ $viewer?->profile?->location ?? 'Pilih partner barter' }}</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-6 text-slate-600">
                        {{ $viewer?->profile?->bio ?? 'Match dihitung dari kategori offer, need, kata kunci, mode kerja, dan riwayat reputasi.' }}
                    </p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h2 class="text-base font-semibold text-slate-950">Offer saya</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($offers as $offer)
                            <a href="{{ route('offers.show', $offer) }}" class="block rounded-lg border border-slate-200 p-4 hover:bg-slate-50">
                                <p class="text-sm font-semibold text-slate-950">{{ $offer->title }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $offer->category }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada offer.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5">
                    <h2 class="text-base font-semibold text-slate-950">Need saya</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($needs as $need)
                            <a href="{{ route('needs.show', $need) }}" class="block rounded-lg border border-slate-200 p-4 hover:bg-slate-50">
                                <p class="text-sm font-semibold text-slate-950">{{ $need->title }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $need->category }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada need.</p>
                        @endforelse
                    </div>
                </section>
            </aside>

            <section class="space-y-6">
                <div>
                    <p class="text-sm font-semibold text-teal-700">Rekomendasi partner</p>
                    <h2 class="mt-2 text-3xl font-semibold text-slate-950">Match yang paling dekat dengan profilmu</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">
                        Prioritas tertinggi diberikan ke partner yang bisa menerima offer kamu dan punya offer untuk need kamu.
                    </p>
                </div>

                <div class="grid gap-4 xl:grid-cols-2">
                    @forelse ($recommendations as $item)
                        <article class="rounded-lg border border-slate-200 bg-white p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex min-w-0 items-center gap-3">
                                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $item['user']->profile_photo_url }}" alt="{{ $item['user']->name }}">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-semibold text-slate-950">{{ $item['user']->name }}</h3>
                                        <p class="truncate text-sm text-slate-500">{{ $item['user']->profile?->location ?? 'Lokasi fleksibel' }} · {{ $item['user']->profile?->work_mode ?? 'online' }}</p>
                                    </div>
                                </div>
                                <div class="rounded-lg bg-teal-50 px-3 py-2 text-center">
                                    <strong class="block text-lg text-teal-800">{{ $item['score'] }}%</strong>
                                    <span class="text-xs font-semibold text-teal-700">match</span>
                                </div>
                            </div>

                            <p class="mt-4 text-sm leading-6 text-slate-600">{{ $item['summary'] }}</p>

                            <div class="mt-4 grid gap-3">
                                @if ($item['my_offer'] && $item['their_need'])
                                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                        <p class="text-xs font-semibold uppercase tracking-normal text-slate-500">Offer kamu cocok untuk</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-950">{{ $item['their_need']->title }}</p>
                                    </div>
                                @endif

                                @if ($item['their_offer'] && $item['my_need'])
                                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                        <p class="text-xs font-semibold uppercase tracking-normal text-slate-500">Offer mereka cocok untuk</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-950">{{ $item['my_need']->title }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($item['user']->skills->take(3) as $skill)
                                    <span class="rounded-md border border-slate-200 px-2 py-1 text-xs font-semibold text-slate-600">{{ $skill->name }}</span>
                                @endforeach
                            </div>

                            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="mt-5 inline-flex rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                                Mulai exchange
                            </a>
                        </article>
                    @empty
                        <div class="rounded-lg border border-dashed border-slate-300 bg-white p-6 text-sm text-slate-500">
                            Belum ada match yang bisa ditampilkan.
                        </div>
                    @endforelse
                </div>
            </section>
        </section>
    </main>
@endcomponent
