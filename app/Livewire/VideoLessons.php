<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class VideoLessons extends Component
{
    use WithFileUploads;

    // Form Variables
    public $title;
    public $level = 'A0';
    public $video_url;
    
    // Filter Variable
    public $filterLevel = ''; 

    // NEW: Editing & Modal State
    public $isEditing = false;       // Are we in "Edit Mode"?
    public $editingId = null;        // Which ID are we editing?
    public $showManageModal = false; // Is the "Edit/Delete" popup open?
    public $selectedVideoForAction = null; // Storing the video object temporarily

    protected $rules = [
        'title' => 'required|min:5',
        'level' => 'required',
        'video_url' => 'required|url',
    ];

    // 1. OPEN THE POPUP
    public function selectVideo($id)
    {
        if (!Auth::user()->isTeacher()) return;

        $this->selectedVideoForAction = Material::find($id);
        $this->showManageModal = true;
    }

    // 2. CHOSE "DELETE"
    public function deleteVideo()
    {
        if (!Auth::user()->isTeacher()) abort(403);

        if ($this->selectedVideoForAction) {
            $this->selectedVideoForAction->delete();
            session()->flash('message', 'Video deleted successfully.');
        }

        $this->closeModal();
    }

    // 3. CHOSE "EDIT"
    public function editVideo()
    {
        if (!Auth::user()->isTeacher()) abort(403);

        // Load data into the top form
        $this->title = $this->selectedVideoForAction->title;
        $this->level = $this->selectedVideoForAction->level;
        $this->video_url = $this->selectedVideoForAction->content_url;
        
        // Set "Edit Mode"
        $this->isEditing = true;
        $this->editingId = $this->selectedVideoForAction->id;

        $this->closeModal();
    }

    // 4. CANCEL EVERYTHING
    public function closeModal()
    {
        $this->showManageModal = false;
        $this->selectedVideoForAction = null;
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'level', 'video_url', 'isEditing', 'editingId']);
    }

    // 5. SAVE (Handles both Create AND Update)
    public function saveVideo()
    {
        if (!Auth::user()->isTeacher()) abort(403);
        $this->validate();

        if ($this->isEditing) {
            // UPDATE EXISTING
            $video = Material::find($this->editingId);
            $video->update([
                'title' => $this->title,
                'level' => $this->level,
                'content_url' => $this->video_url,
            ]);
            session()->flash('message', 'Video updated successfully!');
        } else {
            // CREATE NEW
            Material::create([
                'title' => $this->title,
                'level' => $this->level,
                'type' => 'video',
                'content_url' => $this->video_url,
            ]);
            session()->flash('message', 'Video published successfully!');
        }

        $this->cancelEdit(); // Reset form
    }

    public function render()
    {
        $user = Auth::user();
        $query = Material::where('type', 'video');

        // Apply Filter
        if (!empty($this->filterLevel)) {
            $query->where('level', $this->filterLevel);
        }

        // Student Visibility Logic
        if (!$user->isTeacher()) {
            $allowedLevels = ['A0'];
            if (str_contains($user->level, 'A1') || str_contains($user->level, 'A2') || str_contains($user->level, 'B1')) $allowedLevels[] = 'A1';
            if (str_contains($user->level, 'A2') || str_contains($user->level, 'B1')) $allowedLevels[] = 'A2';
            if (str_contains($user->level, 'B1')) $allowedLevels[] = 'B1';
            $query->whereIn('level', $allowedLevels);
        }

        $videos = $query->latest()->get();

        return view('livewire.video-lessons', ['videos' => $videos]);
    }
}