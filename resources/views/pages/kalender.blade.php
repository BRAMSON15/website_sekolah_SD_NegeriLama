@extends('layouts.app')

@section('title', 'Kalender Pendidikan - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<section class="calendar-page">
  <div class="calendar-heading">
    <div><span class="calendar-eyebrow">INFORMASI AKADEMIK</span><h1>Kalender Pendidikan</h1><p>Jadwal kegiatan dan hari penting sekolah.</p></div>
    <span class="calendar-count"><i class="fa-solid fa-calendar-day"></i> {{ $events->count() }} agenda bulan ini</span>
  </div>
  <div class="calendar-toolbar">
    <a href="{{ route('kalender.index', ['month' => $previousMonth]) }}" aria-label="Bulan sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
    <h2>{{ $month->translatedFormat('F Y') }}</h2>
    <a href="{{ route('kalender.index', ['month' => $nextMonth]) }}" aria-label="Bulan berikutnya"><i class="fa-solid fa-chevron-right"></i></a>
    <form method="GET" action="{{ route('kalender.index') }}"><label for="calendar-month">Pilih bulan</label><input id="calendar-month" type="month" name="month" value="{{ $month->format('Y-m') }}"><button type="submit">Tampilkan</button></form>
  </div>
  <div class="calendar-grid" role="grid" aria-label="Kalender pendidikan {{ $month->translatedFormat('F Y') }}">
    @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $weekday)<div class="calendar-weekday" role="columnheader">{{ $weekday }}</div>@endforeach
    @foreach($calendarWeeks as $week)
      @foreach($week as $day)
        <div class="calendar-day {{ $day['inMonth'] ? '' : 'calendar-day-outside' }} {{ $day['date']->isToday() ? 'calendar-day-today' : '' }}" role="gridcell">
          <span class="calendar-date">{{ $day['date']->format('j') }}</span>
          @foreach($day['events'] as $event)
            <div class="calendar-event calendar-event-{{ \Illuminate\Support\Str::slug($event->category) }}" title="{{ $event->title }}: {{ $event->category }}"><span>{{ $event->title }}</span></div>
          @endforeach
        </div>
      @endforeach
    @endforeach
  </div>
  <div class="calendar-agenda">
    <h2>Agenda {{ $month->translatedFormat('F') }}</h2>
    @forelse($events as $event)
      <article class="calendar-agenda-item"><div class="calendar-agenda-date"><strong>{{ $event->start_date->format('d') }}</strong><span>{{ $event->start_date->translatedFormat('M') }}</span></div><div><span class="calendar-category">{{ $event->category }}</span><h3>{{ $event->title }}</h3><p>{{ $event->start_date->translatedFormat('d F Y') }}@if(!$event->start_date->isSameDay($event->end_date)) – {{ $event->end_date->translatedFormat('d F Y') }}@endif</p>@if($event->description)<p>{{ $event->description }}</p>@endif</div></article>
    @empty
      <p class="calendar-empty">Belum ada agenda aktif pada bulan ini.</p>
    @endforelse
  </div>
</section>
<style>
  .calendar-page{max-width:1180px;margin:0 auto;padding:56px 24px 80px;color:#172b3a}.calendar-heading{display:flex;justify-content:space-between;align-items:end;gap:24px;margin-bottom:28px}.calendar-eyebrow{font-size:.76rem;font-weight:800;letter-spacing:0;color:#087e75}.calendar-heading h1{font-size:2rem;margin:8px 0;color:#153345}.calendar-heading p{margin:0;color:#637482}.calendar-count{white-space:nowrap;color:#087e75;font-weight:700}.calendar-toolbar{display:flex;align-items:center;gap:16px;border-block:1px solid #dce5e8;padding:16px 0;margin-bottom:14px}.calendar-toolbar>a{width:38px;height:38px;display:grid;place-items:center;border:1px solid #dce5e8;border-radius:6px;color:#153345}.calendar-toolbar h2{font-size:1.15rem;margin:0;min-width:150px}.calendar-toolbar form{margin-left:auto;display:flex;align-items:center;gap:8px}.calendar-toolbar label{font-size:.82rem;color:#637482}.calendar-toolbar input,.calendar-toolbar button{height:38px;border:1px solid #cbd7dc;border-radius:5px;padding:0 10px;background:#fff}.calendar-toolbar button{background:#087e75;color:#fff;border-color:#087e75;font-weight:700}.calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));border-top:1px solid #dce5e8;border-left:1px solid #dce5e8}.calendar-weekday{text-align:center;padding:11px;background:#edf4f3;color:#36515b;font-size:.8rem;font-weight:800;border-right:1px solid #dce5e8;border-bottom:1px solid #dce5e8}.calendar-day{min-height:112px;padding:8px;border-right:1px solid #dce5e8;border-bottom:1px solid #dce5e8;background:#fff;overflow:hidden}.calendar-day-outside{background:#f7f9f9;color:#a3afb5}.calendar-day-today{box-shadow:inset 0 0 0 2px #087e75}.calendar-date{display:block;font-weight:700;font-size:.86rem;margin-bottom:6px}.calendar-event{font-size:.72rem;line-height:1.25;padding:4px 5px;margin:3px 0;border-radius:3px;background:#d8f0eb;color:#135b51;overflow:hidden}.calendar-event span{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.calendar-event-ujian{background:#fff0cf;color:#74520c}.calendar-event-libur{background:#fce3df;color:#853a30}.calendar-event-kegiatan{background:#dfeafb;color:#244d7a}.calendar-agenda{margin-top:38px}.calendar-agenda h2{font-size:1.25rem;margin-bottom:14px}.calendar-agenda-item{display:flex;gap:16px;padding:17px 0;border-top:1px solid #dce5e8}.calendar-agenda-date{width:54px;height:58px;flex:none;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#edf4f3;color:#087e75;border-radius:5px}.calendar-agenda-date strong{font-size:1.25rem;line-height:1}.calendar-agenda-date span{font-size:.75rem;text-transform:uppercase;font-weight:700}.calendar-category{font-size:.72rem;text-transform:uppercase;font-weight:800;color:#087e75}.calendar-agenda-item h3{font-size:1rem;margin:3px 0}.calendar-agenda-item p{font-size:.88rem;color:#637482;margin:3px 0}.calendar-empty{color:#637482;padding:16px 0}@media(max-width:700px){.calendar-page{padding:38px 14px 60px}.calendar-heading{align-items:start;flex-direction:column}.calendar-toolbar{flex-wrap:wrap;gap:9px}.calendar-toolbar h2{min-width:0;flex:1}.calendar-toolbar form{width:100%;margin:8px 0 0}.calendar-toolbar form label{display:none}.calendar-toolbar input{flex:1;min-width:0}.calendar-day{min-height:78px;padding:5px 3px}.calendar-weekday{padding:8px 2px;font-size:.72rem}.calendar-event{font-size:.63rem;padding:3px}.calendar-heading h1{font-size:1.7rem}}
</style>
@endsection