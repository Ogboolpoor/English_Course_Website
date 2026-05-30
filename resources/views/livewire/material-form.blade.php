<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
    
    <h2 class="text-2xl font-bold mb-4 text-blue-900">Share Resource / Upload Material</h2>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input type="text" wire:model="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">English Level</label>
            <select wire:model="level" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="A1">A1 (Beginner)</option>
                <option value="A2">A2 (Elementary)</option>
                <option value="B1">B1 (Intermediate)</option>
                <option value="B2">B2 (Upper Intermediate)</option>
            </select>
            @error('level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Material Type</label>
            <select wire:model.live="type" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="pdf">PDF Document</option>
                <option value="video">YouTube Video</option>
            </select>
            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        @if($type === 'pdf')
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Upload PDF</label>
                <input type="file" wire:model="file_upload" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <div wire:loading wire:target="file_upload" class="text-blue-500 text-xs mt-1">Uploading...</div>
                @error('file_upload') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        @endif

        @if($type === 'video')
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">YouTube URL</label>
                <input type="text" wire:model="video_url" placeholder="https://www.youtube.com/watch?v=..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('video_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        @endif

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Save Material
        </button>
    </form>
</div>