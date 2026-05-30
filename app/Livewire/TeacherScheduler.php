<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TeacherScheduler extends Component
{
    public $students;
    public $selectedStudentId = null;

    // Calendar State
    public $currentMonth;
    public $currentYear;

    // Modal State
    public $showModal = false;
    public $selectedDate;
    public $timeInput;

    public function mount()
    {
        // Get all users who represent students (Not the teacher)
        $this->students = User::where('email', '!=', Auth::user()->email)->get();
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }

    public function openLessonModal($date)
    {
        $this->selectedDate = $date;
        $this->showModal = true;
        $this->timeInput = ''; // Reset input
    }

    public function saveLesson()
    {
        $this->validate(['timeInput' => 'required']);

        Lesson::create([
            'user_id' => $this->selectedStudentId,
            'lesson_date' => $this->selectedDate,
            'lesson_time' => $this->timeInput,
            'homework' => null, // Default empty
        ]);

        $this->showModal = false;
        session()->flash('message', 'Lesson assigned!');
    }

    public function render()
    {
        $calendarData = [];
        $lessons = [];

        if ($this->selectedStudentId) {
            // 1. Get dates for the grid
            $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
            $daysInMonth = $date->daysInMonth;
            $startDayOfWeek = $date->dayOfWeek; // 0 (Sun) - 6 (Sat)

            // 2. Fetch existing lessons for this student/month
            $lessons = Lesson::where('user_id', $this->selectedStudentId)
                ->whereMonth('lesson_date', $this->currentMonth)
                ->whereYear('lesson_date', $this->currentYear)
                ->get()
                ->keyBy('lesson_date'); // Key by date for easy lookup

            $calendarData = [
                'daysInMonth' => $daysInMonth,
                'startDayOfWeek' => $startDayOfWeek,
                'monthName' => $date->format('F Y')
            ];
        }

        return view('livewire.teacher-scheduler', [
            'calendar' => $calendarData,
            'existingLessons' => $lessons
        ]);
    }
}
