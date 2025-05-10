@extends('layouts.userLayout')

@section('title', 'Tiket Aja - Event')

@section('content')
<div class="container mx-auto px-4 py-6">

  <!-- Event Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6">
    @foreach($events as $event)
      <div class="bg-white shadow-lg p-4 rounded-lg flex flex-col">
        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
             class="w-full h-40 sm:h-32 md:h-40 lg:h-48 rounded-md object-cover mb-3" />
        <h2 class="font-semibold text-blue-700 text-sm mb-1">{{ $event->name }}</h2>
        <p class="flex items-center gap-1 text-xs text-slate-500 mb-1">
          <i class="bx bxs-calendar"></i>
          {{ \Carbon\Carbon::parse($event->date)->format('l, d M Y') }}
        </p>
        <p class="flex items-center gap-1 text-xs text-slate-500 mb-3">
          <i class="bx bx-current-location"></i>
          {{ $event->location }}
        </p>
        <div class="mt-auto flex items-center justify-between">
          @if($event->tickets->count() > 0)
            <span class="text-orange-500 font-bold text-sm">
              Rp{{ number_format($event->tickets->first()->price, 0, ',', '.') }}
            </span>
          @else
            <span class="text-orange-500 font-bold text-sm">Soldout</span>
          @endif
          <a href="{{ route('user.catalogue.showEvent', ['id_event'=>$event->id_event]) }}"
             class="bg-blue-800 text-white text-xs py-1 px-3 rounded-md hover:bg-blue-700">Lihat Tiket</a>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $events->links() }}
  </div>
</div>
@endsection
