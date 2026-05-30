<div class="py-6 relative">

    @if($showManageModal)
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 w-96 transform transition-all scale-100">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Manage Lesson</h3>
                <p class="text-gray-600 mb-6 italic truncate">"{{ $selectedVideoForAction->title }}"</p>

                <div class="flex flex-col gap-3">
                    <button wire:click="editVideo" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold py-2 px-4 rounded flex items-center justify-center gap-2 border border-gray-300 transition-colors">
                        ✏️ Edit Lesson
                    </button>

                    <button wire:click="deleteVideo" wire:confirm="Are you sure? This cannot be undone." class="w-full bg-gray-900 hover:bg-black text-white font-bold py-2 px-4 rounded flex items-center justify-center gap-2 transition-colors">
                        🗑️ Delete Lesson
                    </button>

                    <button wire:click="closeModal" class="w-full bg-white hover:bg-gray-50 text-gray-600 font-bold py-2 px-4 rounded mt-2 border border-gray-200 transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif


    @if(Auth::user()->isTeacher())
        <div class="mb-8 p-6 rounded-lg border transition-colors duration-300 {{ $isEditing ? 'bg-gray-50 border-gray-300' : 'bg-white border-gray-200 shadow-sm' }}">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold {{ $isEditing ? 'text-gray-800' : 'text-gray-900' }}">
                    {{ $isEditing ? '✏️ Editing: "' . $title . '"' : 'Teacher Control Panel' }}
                </h2>

                @if($isEditing)
                    <button wire:click="cancelEdit" class="text-sm text-gray-500 underline hover:text-gray-800 transition-colors">Cancel Edit</button>
                @endif
            </div>

            @if (session()->has('message'))
                <div class="mb-4 text-white font-bold bg-gray-800 p-3 rounded">{{ session('message') }}</div>
            @endif

            <form wire:submit.prevent="saveVideo" class="flex flex-col gap-4">
                <input type="text" wire:model.live="title" placeholder="Video Title" class="border-gray-300 rounded-md shadow-sm w-full focus:border-gray-500 focus:ring-gray-500">
                <div class="flex gap-2">
                    <select wire:model="level" class="w-48 border-gray-300 rounded-md shadow-sm focus:border-gray-500 focus:ring-gray-500">
                        <option value="A0">Level A0</option>
                        <option value="A1">Level A1</option>
                        <option value="A2">Level A2</option>
                        <option value="B1">Level B1</option>
                    </select>
                    <input type="text" wire:model="video_url" placeholder="Paste YouTube Link" class="border-gray-300 rounded-md shadow-sm flex-1 focus:border-gray-500 focus:ring-gray-500">
                </div>

                <button type="submit" class="py-2 px-4 rounded font-bold transition-colors bg-gray-900 hover:bg-black text-white">
                    {{ $isEditing ? 'Update Lesson' : 'Upload New Lesson' }}
                </button>
            </form>
        </div>
    @endif


    <div class="bg-white p-6 shadow-sm rounded-lg border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Video Lessons</h2>
            <select wire:model.live="filterLevel" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-gray-500 focus:ring-gray-500">
                <option value="">All Levels</option>
                <option value="A0">Show A0</option>
                <option value="A1">Show A1</option>
                <option value="A2">Show A2</option>
                <option value="B1">Show B1</option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($videos as $video)
                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition bg-white flex flex-col group relative">

                    <div class="p-3 border-b border-gray-100 bg-gray-50 flex justify-between items-center h-12">

                        @if(Auth::user()->isTeacher())
                            <button
                                wire:click="selectVideo({{ $video->id }})"
                                class="font-bold text-sm text-gray-700 hover:text-gray-900 hover:underline truncate pr-2 text-left w-full transition-colors"
                                title="Click to Manage">
                                {{ $video->title }} ⚙️
                            </button>
                        @else
                            <h3 class="font-bold text-sm text-gray-700 truncate pr-2" title="{{ $video->title }}">
                                {{ $video->title }}
                            </h3>
                        @endif

                        <span class="bg-gray-200 text-gray-700 text-xs font-bold px-2 py-1 rounded shrink-0">
                            {{ $video->level }}
                        </span>
                    </div>

                    <div class="aspect-video w-full bg-black">
                        @php
                            $videoID = '';
                            $url = $video->content_url;
                            // ... (Video ID extraction logic remains the same) ...
                            if (str_contains($url, 'watch?v=')) { $parts = explode('watch?v=', $url); $videoID = explode('&', $parts[1])[0]; }
                            elseif (str_contains($url, 'youtu.be/')) { $parts = explode('youtu.be/', $url); $videoID = $parts[1]; }
                            elseif (str_contains($url, 'embed/')) { $parts = explode('embed/', $url); $videoID = $parts[1]; }
                            $embedUrl = 'https://www.youtube.com/embed/' . $videoID;
                        @endphp
                        <iframe class="w-full h-full" src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            @endforeach
        </div>

        @if($videos->isEmpty())
            <div class="text-center text-gray-500 py-8">No videos found.</div>
        @endif
    </div>
</div>
