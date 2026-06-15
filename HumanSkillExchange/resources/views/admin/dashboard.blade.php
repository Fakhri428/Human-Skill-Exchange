@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <section class="mb-6">
        <h2 class="font-semibold">Recent Users</h2>
        <ul class="list-disc pl-6">
            @foreach($users as $u)
                <li>{{ $u->name }} — {{ $u->email }}</li>
            @endforeach
        </ul>
    </section>

    <section class="mb-6">
        <h2 class="font-semibold">Recent Mentoring Rooms</h2>
        <ul class="list-disc pl-6">
            @foreach($rooms as $r)
                <li>{{ $r->title }} — by {{ $r->user->name ?? 'n/a' }} (mentor: {{ $r->mentor->name ?? 'n/a' }})</li>
            @endforeach
        </ul>
    </section>

    <section class="mb-6">
        <h2 class="font-semibold">Recent Bookings</h2>
        <ul class="list-disc pl-6">
            @foreach($bookings as $b)
                <li class="mb-2">
                    {{ $b->user->email ?? 'n/a' }} — {{ $b->room->title ?? 'n/a' }} — <strong>{{ $b->status }}</strong>
                    @can('admin')
                        <form action="{{ route('admin.bookings.approve', $b) }}" method="post" style="display:inline">
                            @csrf
                            <button class="ml-2 px-2 py-1 bg-green-500 text-white rounded" type="submit">Approve</button>
                        </form>
                        <form action="{{ route('admin.bookings.decline', $b) }}" method="post" style="display:inline">
                            @csrf
                            <button class="ml-1 px-2 py-1 bg-red-500 text-white rounded" type="submit">Decline</button>
                        </form>
                    @endcan
                </li>
            @endforeach
        </ul>
    </section>

    <section>
        <h2 class="font-semibold">Recent Transactions</h2>
        <ul class="list-disc pl-6">
            @foreach($transactions as $t)
                <li>{{ $t->user->email ?? 'n/a' }} — {{ $t->amount }} {{ $t->currency }} — {{ $t->status }}</li>
            @endforeach
        </ul>
    </section>
</div>
@endsection
