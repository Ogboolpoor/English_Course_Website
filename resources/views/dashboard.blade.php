<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->isTeacher() ? 'Teacher Dashboard' : 'Student Dashboard' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(Auth::user()->isTeacher())
                <div class="space-y-8">
                    <livewire:teacher-scheduler />
                </div>
            @else
                <div class="space-y-8">
                    <livewire:student-calendar />
                    <livewire:video-lessons />
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
