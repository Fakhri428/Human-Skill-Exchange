@php
    $metricTone = [
        'teal' => 'border-teal-200 bg-teal-50 text-teal-950',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-950',
        'indigo' => 'border-indigo-200 bg-indigo-50 text-indigo-950',
        'rose' => 'border-rose-200 bg-rose-50 text-rose-950',
    ];
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
        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-semibold leading-tight text-slate-900">
                Dashboard Member
            </h2>
            <p class="text-sm text-slate-500">Kelola skill, offer, need, dan exchange.</p>
        </div>
    </x-slot>

    <div class="bg-slate-50 py-8">
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-teal-200 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-900">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900">
                    <p class="font-semibold">Ada data yang perlu diperbaiki.</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
                <div class="space-y-6">
                    <section class="rounded-lg border border-slate-200 bg-white p-6">
                        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center gap-4">
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ $viewer->profile_photo_url }}" alt="{{ $viewer->name }}">
                                <div>
                                    <p class="text-sm font-semibold text-teal-700">{{ $viewer->plan?->name ?? 'Gratis' }}</p>
                                    <h1 class="mt-1 text-2xl font-semibold text-slate-950">{{ $viewer->name }}</h1>
                                    <p class="mt-1 text-sm text-slate-500">{{ $viewer->profile?->location ?? 'Lokasi belum diisi' }} · {{ $viewer->profile?->work_mode ?? 'online' }}</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('market') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50">Cari offer</a>
                                <a href="{{ route('matches') }}" class="rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">Lihat match</a>
                            </div>
                        </div>
                    </section>

                    <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($stats as $stat)
                            <div class="rounded-lg border p-4 {{ $metricTone[$stat['tone']] ?? 'border-slate-200 bg-white text-slate-950' }}">
                                <div class="text-2xl font-semibold">{{ $stat['value'] }}</div>
                                <div class="mt-1 text-xs font-semibold uppercase tracking-normal">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6">
                        <div class="mb-5">
                            <h2 class="text-base font-semibold text-slate-950">Profil exchange</h2>
                            <p class="mt-1 text-sm text-slate-500">Data ini dipakai untuk personal branding dan rekomendasi match.</p>
                        </div>

                        <form method="POST" action="{{ route('exchange.profile.update') }}" class="grid gap-4 lg:grid-cols-2">
                            @csrf
                            <div class="lg:col-span-2">
                                <label for="bio" class="text-sm font-semibold text-slate-700">Bio</label>
                                <textarea id="bio" name="bio" rows="3" required class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('bio', $viewer->profile?->bio ?? '') }}</textarea>
                            </div>
                            <div>
                                <label for="location" class="text-sm font-semibold text-slate-700">Lokasi</label>
                                <input id="location" name="location" value="{{ old('location', $viewer->profile?->location ?? '') }}" required class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>
                            <div>
                                <label for="work_mode" class="text-sm font-semibold text-slate-700">Mode kerja</label>
                                <select id="work_mode" name="work_mode" required class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    @foreach (['online' => 'Online', 'offline' => 'Offline', 'hybrid' => 'Hybrid'] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('work_mode', $viewer->profile?->work_mode ?? 'online') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="available_time" class="text-sm font-semibold text-slate-700">Waktu tersedia</label>
                                <input id="available_time" name="available_time" value="{{ old('available_time', $viewer->profile?->available_time ?? '') }}" required class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>
                            <div>
                                <label for="portfolio_url" class="text-sm font-semibold text-slate-700">Portfolio URL</label>
                                <input id="portfolio_url" name="portfolio_url" value="{{ old('portfolio_url', $viewer->profile?->portfolio_url ?? '') }}" type="url" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>
                            <div>
                                <label for="social_url" class="text-sm font-semibold text-slate-700">Social URL</label>
                                <input id="social_url" name="social_url" value="{{ old('social_url', $viewer->profile?->social_url ?? '') }}" type="url" class="mt-2 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>
                            <div class="lg:col-span-2 flex justify-end">
                                <button type="submit" class="rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan profil</button>
                            </div>
                        </form>
                    </section>

                    <section class="grid gap-6 xl:grid-cols-4">
                        <article class="rounded-lg border border-slate-200 bg-white p-5">
                            <h2 class="text-base font-semibold text-slate-950">Tambah skill</h2>
                            <form method="POST" action="{{ route('skills.store') }}" class="mt-4 space-y-3">
                                @csrf
                                <input name="name" value="{{ old('name') }}" placeholder="Laravel REST API" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <input name="category" value="{{ old('category') }}" placeholder="Programming" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <select name="level" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <option value="beginner" @selected(old('level') === 'beginner')>Beginner</option>
                                    <option value="intermediate" @selected(old('level', 'intermediate') === 'intermediate')>Intermediate</option>
                                    <option value="advanced" @selected(old('level') === 'advanced')>Advanced</option>
                                </select>
                                <button type="submit" class="w-full rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">Tambah skill</button>
                            </form>
                        </article>

                        <article class="rounded-lg border border-slate-200 bg-white p-5">
                            <h2 class="text-base font-semibold text-slate-950">Buat offer</h2>
                            <form method="POST" action="{{ route('offers.store') }}" class="mt-4 space-y-3">
                                @csrf
                                <input name="title" value="{{ old('title') }}" placeholder="Saya bisa bantu..." required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <select name="type" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                        <option value="skill">Skill</option>
                                        <option value="waktu">Waktu</option>
                                        <option value="pengalaman">Pengalaman</option>
                                        <option value="mentoring">Mentoring</option>
                                        <option value="bantuan_project">Bantuan project</option>
                                        <option value="kolaborasi">Kolaborasi</option>
                                    </select>
                                    <input name="category" value="{{ old('category') }}" placeholder="Design" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                </div>
                                <textarea name="description" rows="3" placeholder="Jelaskan bantuan yang bisa kamu berikan" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('description') }}</textarea>
                                <textarea name="exchange_expectation" rows="2" placeholder="Kamu ingin ditukar dengan apa?" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('exchange_expectation') }}</textarea>
                                <input name="available_duration" value="{{ old('available_duration') }}" placeholder="3 jam per minggu" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <button type="submit" class="w-full rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">Publikasikan offer</button>
                            </form>
                        </article>

                        <article class="rounded-lg border border-slate-200 bg-white p-5">
                            <h2 class="text-base font-semibold text-slate-950">Buat need</h2>
                            <form method="POST" action="{{ route('needs.store') }}" class="mt-4 space-y-3">
                                @csrf
                                <input name="title" value="{{ old('title') }}" placeholder="Butuh bantuan..." required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <input name="category" value="{{ old('category') }}" placeholder="Programming" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <textarea name="description" rows="3" placeholder="Jelaskan kebutuhanmu" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('description') }}</textarea>
                                <textarea name="exchange_offer" rows="2" placeholder="Apa yang bisa kamu berikan sebagai barter?" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('exchange_offer') }}</textarea>
                                <button type="submit" class="w-full rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">Publikasikan need</button>
                            </form>
                        </article>

                        <article class="rounded-lg border border-slate-200 bg-white p-5">
                            <h2 class="text-base font-semibold text-slate-950">Tambah portfolio</h2>
                            <form method="POST" action="{{ route('portfolios.store') }}" class="mt-4 space-y-3">
                                @csrf
                                <input name="title" value="{{ old('title') }}" placeholder="Portofolio Laravel API" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <textarea name="description" rows="3" placeholder="Jelaskan project atau hasil kerja" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('description') }}</textarea>
                                <input name="file_url" value="{{ old('file_url') }}" placeholder="Link file / gambar" type="url" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <input name="project_url" value="{{ old('project_url') }}" placeholder="Link project" type="url" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <button type="submit" class="w-full rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">Simpan portfolio</button>
                            </form>
                        </article>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white">
                        <div class="border-b border-slate-200 px-5 py-4">
                            <h2 class="text-base font-semibold text-slate-950">Portfolio saya</h2>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @forelse ($viewer->portfolios as $portfolio)
                                <article class="p-5">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="font-semibold text-slate-950">{{ $portfolio->title }}</p>
                                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $portfolio->description }}</p>
                                            <div class="mt-2 flex flex-wrap gap-3 text-xs text-teal-700">
                                                @if ($portfolio->file_url)
                                                    <a href="{{ $portfolio->file_url }}" target="_blank" class="font-semibold hover:underline">Lihat file</a>
                                                @endif
                                                @if ($portfolio->project_url)
                                                    <a href="{{ $portfolio->project_url }}" target="_blank" class="font-semibold hover:underline">Lihat project</a>
                                                @endif
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('portfolios.destroy', $portfolio) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                                        </form>
                                    </div>
                                </article>
                            @empty
                                <div class="p-5 text-sm text-slate-500">Belum ada portfolio.</div>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <h2 class="text-base font-semibold text-slate-950">Mentoring</h2>
                        <p class="mt-1 text-sm text-slate-500">Pesan sesi mentoring dengan mentor yang tersedia.</p>

                        <div class="mt-4 grid gap-4">
                            @forelse ($mentoringRooms as $room)
                                <div class="rounded-md border p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold">{{ $room->title }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $room->description }}</p>
                                            <p class="mt-2 text-xs text-slate-500">Mentor: {{ $room->mentor?->name ?? 'n/a' }}</p>
                                        </div>
                                        <div class="w-48">
                                            <form method="POST" action="{{ route('mentoring-bookings.store') }}" class="space-y-2">
                                                @csrf
                                                <input type="hidden" name="mentoring_room_id" value="{{ $room->id }}">
                                                <input name="scheduled_at" type="datetime-local" required class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                                <input name="duration_minutes" type="number" min="15" placeholder="Durasi (menit)" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                                <button type="submit" class="w-full rounded-md bg-teal-600 px-3 py-2 text-xs font-semibold text-white hover:bg-teal-700">Pesan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-slate-500">Belum ada mentor tersedia.</div>
                            @endforelse
                        </div>
                    </section>

                    <section class="grid gap-6 xl:grid-cols-2">
                        <article class="rounded-lg border border-slate-200 bg-white">
                            <div class="border-b border-slate-200 px-5 py-4">
                                <h2 class="text-base font-semibold text-slate-950">Offer saya</h2>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @forelse ($viewer->offers as $offer)
                                    <a href="{{ route('offers.show', $offer) }}" class="block p-5 hover:bg-slate-50">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="font-semibold text-slate-950">{{ $offer->title }}</p>
                                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $offer->description }}</p>
                                            </div>
                                            <span class="shrink-0 rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600">{{ $offer->category }}</span>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-5 text-sm text-slate-500">Belum ada offer.</div>
                                @endforelse
                            </div>
                        </article>

                        <article class="rounded-lg border border-slate-200 bg-white">
                            <div class="border-b border-slate-200 px-5 py-4">
                                <h2 class="text-base font-semibold text-slate-950">Need saya</h2>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @forelse ($viewer->needs as $need)
                                    <a href="{{ route('needs.show', $need) }}" class="block p-5 hover:bg-slate-50">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="font-semibold text-slate-950">{{ $need->title }}</p>
                                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $need->description }}</p>
                                            </div>
                                            <span class="shrink-0 rounded-md bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-700">{{ $need->category }}</span>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-5 text-sm text-slate-500">Belum ada need.</div>
                                @endforelse
                            </div>
                        </article>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white">
                        <div class="border-b border-slate-200 px-5 py-4">
                            <h2 class="text-base font-semibold text-slate-950">Exchange request</h2>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @forelse ($exchangeRequests as $exchange)
                                <article class="p-5">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="font-semibold text-slate-950">
                                                {{ $exchange->fromUser?->name }} ke {{ $exchange->toUser?->name }}
                                            </p>
                                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $exchange->message }}</p>
                                            <p class="mt-2 text-xs text-slate-500">{{ $exchange->offer?->title ?? 'Offer belum tersedia' }} · {{ $exchange->need?->title ?? 'Need belum tersedia' }}</p>
                                        </div>
                                        <span class="shrink-0 rounded-md border px-2 py-1 text-xs font-semibold {{ $statusTone[$exchange->status] ?? 'border-slate-200 bg-slate-50 text-slate-600' }}">
                                            {{ str_replace('_', ' ', $exchange->status) }}
                                        </span>
                                    </div>

                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @if ($exchange->status === 'pending' && (int) $exchange->to_user_id === (int) $viewer->id)
                                            <form method="POST" action="{{ route('exchange-requests.update', $exchange) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="rounded-md bg-teal-600 px-3 py-2 text-xs font-semibold text-white hover:bg-teal-700">Accept</button>
                                            </form>
                                            <form method="POST" action="{{ route('exchange-requests.update', $exchange) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="rounded-md border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Reject</button>
                                            </form>
                                        @endif

                                        @if ($exchange->status === 'pending' && (int) $exchange->from_user_id === (int) $viewer->id)
                                            <form method="POST" action="{{ route('exchange-requests.update', $exchange) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="cancel">
                                                <button type="submit" class="rounded-md border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                                            </form>
                                        @endif

                                        @if ($exchange->status === 'accepted')
                                            <form method="POST" action="{{ route('exchange-requests.update', $exchange) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="start">
                                                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700">Mulai progress</button>
                                            </form>
                                        @endif

                                        @if (in_array($exchange->status, ['accepted', 'in_progress'], true))
                                            @php
                                                $completedByViewer = (int) $exchange->from_user_id === (int) $viewer->id
                                                    ? $exchange->completed_by_from_user
                                                    : $exchange->completed_by_to_user;
                                            @endphp

                                            @unless ($completedByViewer)
                                                <form method="POST" action="{{ route('exchange-requests.update', $exchange) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="action" value="complete">
                                                    <button type="submit" class="rounded-md border border-emerald-200 px-3 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Konfirmasi selesai</button>
                                                </form>
                                            @else
                                                <span class="rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700">Menunggu partner</span>
                                            @endunless
                                        @endif
                                    </div>
                                </article>
                            @empty
                                <div class="p-5 text-sm text-slate-500">Belum ada request exchange.</div>
                            @endforelse
                        </div>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-base font-semibold text-slate-950">Reputasi</h2>
                                <p class="mt-1 text-sm text-slate-500">Trust score akun.</p>
                            </div>
                            <div class="rounded-lg bg-slate-950 px-3 py-2 text-xl font-semibold text-white">{{ $reputation['score'] }}</div>
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

                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <h2 class="text-base font-semibold text-slate-950">Limit plan</h2>
                        <div class="mt-5 space-y-4">
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
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <h2 class="text-base font-semibold text-slate-950">Skill saya</h2>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @forelse ($viewer->skills as $skill)
                                <span class="rounded-md border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700">{{ $skill->name }} · {{ $skill->level }}</span>
                            @empty
                                <span class="text-sm text-slate-500">Belum ada skill.</span>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white">
                        <div class="border-b border-slate-200 px-5 py-4">
                            <h2 class="text-base font-semibold text-slate-950">Match cepat</h2>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @forelse ($recommendations as $item)
                                <article class="p-5">
                                    <div class="flex items-center gap-3">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $item['user']->profile_photo_url }}" alt="{{ $item['user']->name }}">
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-semibold text-slate-950">{{ $item['user']->name }}</p>
                                            <p class="truncate text-xs text-slate-500">{{ $item['label'] }}</p>
                                        </div>
                                        <span class="rounded-md bg-teal-50 px-2 py-1 text-xs font-semibold text-teal-700">{{ $item['score'] }}%</span>
                                    </div>
                                    <p class="mt-3 text-xs leading-5 text-slate-600">{{ $item['summary'] }}</p>
                                </article>
                            @empty
                                <div class="p-5 text-sm text-slate-500">Belum ada match.</div>
                            @endforelse
                        </div>
                    </section>
                </aside>
            </section>
        </main>
    </div>
</x-app-layout>
