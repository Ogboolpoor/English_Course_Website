<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StudentCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    
    // Modal Details
    public $showModal = false;
    public $lessonDetails = null;

    public function mount()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }

    public function checkDate($date)
    {
        // Find lesson for this user on this date
        $lesson = Lesson::where('user_id', Auth::id())
            ->where('lesson_date', $date)
            ->first();

        if ($lesson) {
            $this->lessonDetails = $lesson;
            $this->showModal = true;
        }
    }

    public function render()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        
        // Get Lessons for this month
        $lessons = Lesson::where('user_id', Auth::id())
                ->whereMonth('lesson_date', $this->currentMonth)
                ->whereYear('lesson_date', $this->currentYear)
                ->get()
                ->keyBy('lesson_date');

        return view('livewire.student-calendar', [
            'daysInMonth' => $date->daysInMonth,
            'startDayOfWeek' => $date->dayOfWeek,
            'monthName' => $date->format('F Y'),
            'lessons' => $lessons
        ]);
    }
}