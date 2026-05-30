<div class="flex flex-col md:flex-row gap-8 items-start justify-center">

    <div class="bg-white p-6 rounded-lg shadow-sm w-full md:w-1/3 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-4">📅 Scheduler</h2>

        <label class="block font-bold text-gray-700 text-sm mb-2">Select Student:</label>
        <select wire:model.live="selectedStudentId" class="border-gray-300 rounded-md shadow-sm w-full mb-6 focus:border-gray-500 focus:ring-gray-500">
            <option value="">-- Choose Student --</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>

        @if($selectedStudentId)
            <div class="p-4 bg-gray-50 border border-gray-200 rounded text-sm text-gray-700">
                <p><strong>Active:</strong> {{ $calendar['monthName'] ?? '' }}</p>
                <p class="mt-1">Click any date on the grid to add/edit a lesson.</p>
            </div>
        @endif
    </div>

    @if($selectedStudentId)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden w-full max-w-lg border border-gray-200">

            <div class="bg-gray-900 p-4 text-center">
                <h3 class="text-white text-2xl font-bold uppercase tracking-widest">
                    {{ $calendar['monthName'] }}
                </h3>
            </div>

            <div class="grid grid-cols-7 bg-gray-100 border-b border-gray-200">
                <div class="py-2 text-center text-xs font-black text-gray-600 uppercase">Sun</div>
                <div class="py-2 text-center text-xs font-black text-gray-600 uppercase">Mon</div>
                <div class="py-2 text-center text-xs font-black text-gray-600 uppercase">Tue</div>
                <div class="py-2 text-center text-xs font-black text-gray-600 uppercase">Wed</div>
                <div class="py-2 text-center text-xs font-black text-gray-600 uppercase">Thu</div>
                <div class="py-2 text-center text-xs font-black text-gray-600 uppercase">Fri</div>
                <div class="py-2 text-center text-xs font-black text-gray-600 uppercase">Sat</div>
            </div>

            <div class="grid grid-cols-7 bg-white">
                @for ($i = 0; $i < $calendar['startDayOfWeek']; $i++)
                    <div class="h-16 border-b border-r border-gray-100 bg-white"></div>
                @endfor

                @for ($day = 1; $day <= $calendar['daysInMonth']; $day++)
                    @php
                        $currentDateStr = \Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                        $hasLesson = $existingLessons->has($currentDateStr);
                    @endphp

                    <div
                        wire:click="openLessonModal('{{ $currentDateStr }}')"
                        class="h-16 border-b border-r border-gray-100 flex flex-col items-center justify-start pt-1 cursor-pointer hover:bg-gray-100 transition relative
                        {{ $hasLesson ? 'bg-gray-50' : 'text-gray-500' }}">

                        <span class="text-sm {{ $hasLesson ? 'font-bold text-gray-900' : '' }}">{{ $day }}</span>

                        @if($hasLesson)
                            <div class="mt-1 bg-gray-800 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">
                                {{ \Carbon\Carbon::parse($existingLessons[$currentDateStr]->lesson_time)->format('H:i') }}
                            </div>
                        @endif
                    </div>
                @endfor

                @php
                    $totalCells = $calendar['startDayOfWeek'] + $calendar['daysInMonth'];
                    $remaining = 7 - ($totalCells % 7);
                    if($remaining == 7) $remaining = 0;
                @endphp
                @for ($j = 0; $j < $remaining; $j++)
                    <div class="h-16 border-b border-r border-gray-100 bg-white"></div>
                @endfor
            </div>
        </div>
    @endif

    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-2xl w-80 text-center">
                <h3 class="font-bold text-lg mb-4 text-gray-900">Assign Time</h3>
                <p class="mb-4 text-gray-600">{{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}</p>
                <input type="time" wire:model="timeInput" class="border-gray-300 rounded w-full mb-4 text-center text-lg focus:border-gray-500 focus:ring-gray-500">

                <textarea wire:model="homeworkInput" placeholder="Enter homework here..." class="border-gray-300 rounded w-full mb-4 h-24 focus:border-gray-500 focus:ring-gray-500"></textarea>

                <div class="flex gap-2">
                    <button wire:click="saveLesson" class="bg-gray-900 hover:bg-black text-white w-full py-2 rounded font-bold transition-colors">Save</button>
                    <button wire:click="$set('showModal', false)" class="bg-gray-200 hover:bg-gray-300 text-gray-800 w-full py-2 rounded font-bold transition-colors">Cancel</button>
                </div>
            </div>
        </div>
    @endif
</div>
