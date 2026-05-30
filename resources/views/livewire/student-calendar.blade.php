<div class="flex justify-center w-full">
    <div class="bg-white rounded-lg shadow-md overflow-hidden w-full max-w-3xl border border-gray-200">

        <div class="bg-gray-900 p-5 text-center">
            <h3 class="text-white text-3xl font-bold uppercase tracking-widest">
                {{ $monthName }}
            </h3>
        </div>

        <div class="grid grid-cols-7 bg-gray-100 border-b border-gray-200">
            <div class="py-3 text-center text-sm font-black text-gray-600 uppercase">Sun</div>
            <div class="py-3 text-center text-sm font-black text-gray-600 uppercase">Mon</div>
            <div class="py-3 text-center text-sm font-black text-gray-600 uppercase">Tue</div>
            <div class="py-3 text-center text-sm font-black text-gray-600 uppercase">Wed</div>
            <div class="py-3 text-center text-sm font-black text-gray-600 uppercase">Thu</div>
            <div class="py-3 text-center text-sm font-black text-gray-600 uppercase">Fri</div>
            <div class="py-3 text-center text-sm font-black text-gray-600 uppercase">Sat</div>
        </div>

        <div class="grid grid-cols-7 bg-white">

            @for ($i = 0; $i < $startDayOfWeek; $i++)
                <div class="h-24 border-b border-r border-gray-100 bg-white"></div>
            @endfor

            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $currentDateStr = \Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                    $hasLesson = $lessons->has($currentDateStr);
                @endphp

                <div
                    @if($hasLesson) wire:click="checkDate('{{ $currentDateStr }}')" @endif
                class="h-24 border-b border-r border-gray-100 flex flex-col items-center justify-start pt-2 relative transition-all group
                    {{ $hasLesson ? 'cursor-pointer bg-gray-100 hover:bg-gray-200' : '' }}">

                    <span class="text-xl font-bold {{ $hasLesson ? 'text-gray-900' : 'text-gray-500' }}">
                        {{ $day }}
                    </span>

                    @if($hasLesson)
                        <div class="mt-2 bg-gray-700 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">
                            {{ \Carbon\Carbon::parse($lessons[$currentDateStr]->lesson_time)->format('H:i') }}
                        </div>
                    @endif
                </div>
            @endfor

            @php
                $totalCells = $startDayOfWeek + $daysInMonth;
                $remaining = 7 - ($totalCells % 7);
                if($remaining == 7) $remaining = 0;
            @endphp
            @for ($j = 0; $j < $remaining; $j++)
                <div class="h-24 border-b border-r border-gray-100 bg-white"></div>
            @endfor

        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-2xl w-80 text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Lesson Details</h3>
                <p class="text-lg font-bold text-gray-700 mb-2">{{ \Carbon\Carbon::parse($lessonDetails->lesson_date)->format('F jS') }}</p>
                <p class="text-gray-700 mb-4">Time: <strong>{{ $lessonDetails->lesson_time }}</strong></p>

                <div class="bg-gray-50 p-3 rounded text-left text-sm text-gray-600 italic border border-gray-200">
                    "{{ $lessonDetails->homework ?? 'There is no homework for now.' }}"
                </div>

                <button wire:click="$set('showModal', false)" class="mt-6 w-full bg-gray-900 hover:bg-black text-white py-2 rounded font-bold transition-colors">Close</button>
            </div>
        </div>
    @endif
</div>
