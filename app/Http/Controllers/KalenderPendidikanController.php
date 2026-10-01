<?php

namespace App\Http\Controllers;

use App\Models\EducationalCalendarEvent;
use App\Services\WebsiteContentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KalenderPendidikanController extends Controller
{
    private const CATEGORIES = ['Pembelajaran', 'Ujian', 'Libur', 'Kegiatan', 'Lainnya'];

    public function __construct(protected WebsiteContentService $websiteService) {}

    public function index(Request $request)
    {
        $request->validate(['month' => ['sometimes', 'date_format:Y-m']]);
        $month = Carbon::createFromFormat('!Y-m', $request->query('month', now()->format('Y-m')));
        $events = EducationalCalendarEvent::active()
            ->overlapping($month->copy()->startOfMonth()->toDateString(), $month->copy()->endOfMonth()->toDateString())
            ->orderBy('start_date')
            ->get();

        $calendarWeeks = [];
        $weekStart = $month->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $month->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        while ($weekStart->lte($calendarEnd)) {
            $week = [];
            for ($day = 0; $day < 7; $day++) {
                $date = $weekStart->copy()->addDays($day);
                $week[] = [
                    'date' => $date,
                    'inMonth' => $date->month === $month->month,
                    'events' => $events->filter(fn ($event) => $event->start_date->lte($date) && $event->end_date->gte($date)
                    ),
                ];
            }
            $calendarWeeks[] = $week;
            $weekStart->addWeek();
        }

        return view('pages.kalender', [
            'settings' => $this->websiteService->getSettings(),
            'month' => $month,
            'calendarWeeks' => $calendarWeeks,
            'events' => $events,
            'previousMonth' => $month->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $month->copy()->addMonth()->format('Y-m'),
        ]);
    }

    public function manage()
    {
        $events = EducationalCalendarEvent::orderBy('start_date')->paginate(15);

        return view('information.calendar.index', [
            'settings' => $this->websiteService->getSettings(),
            'events' => $events,
        ]);
    }

    public function create()
    {
        return view('information.calendar.form', [
            'settings' => $this->websiteService->getSettings(),
            'event' => new EducationalCalendarEvent,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        EducationalCalendarEvent::create($this->validatedEvent($request));

        return redirect()->route('admin.kalender.index')->with('success', 'Agenda kalender berhasil ditambahkan.');
    }

    public function edit(EducationalCalendarEvent $educationalCalendarEvent)
    {
        return view('information.calendar.form', [
            'settings' => $this->websiteService->getSettings(),
            'event' => $educationalCalendarEvent,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, EducationalCalendarEvent $educationalCalendarEvent)
    {
        $educationalCalendarEvent->update($this->validatedEvent($request));

        return redirect()->route('admin.kalender.index')->with('success', 'Agenda kalender berhasil diperbarui.');
    }

    public function destroy(EducationalCalendarEvent $educationalCalendarEvent)
    {
        $educationalCalendarEvent->delete();

        return back()->with('success', 'Agenda kalender berhasil dihapus.');
    }

    private function validatedEvent(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'category' => ['required', 'in:'.implode(',', self::CATEGORIES)],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
