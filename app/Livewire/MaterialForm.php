<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Essential for uploading PDFs
use App\Models\Material;

class MaterialForm extends Component
{
    use WithFileUploads;

    public $title;
    public $level = 'A1'; // Default value
    public $type = 'pdf'; // Default value
    public $file_upload;
    public $video_url;

    // Validation Rules
    protected $rules = [
        'title' => 'required|min:5',
        'level' => 'required|in:A1,A2,B1,B2',
        'type' => 'required',
        // If type is PDF, we require a file. If Video, we require a URL.
        'file_upload' => 'required_if:type,pdf|nullable|file|mimes:pdf|max:10240', // Max 10MB
        'video_url' => 'required_if:type,video|nullable|url',
    ];

    public function save()
    {
        $this->validate();

        $path = '';

        // Handle the logic: Save file OR save URL
        if ($this->type === 'pdf') {
            // Stores in storage/app/public/materials
            $path = $this->file_upload->store('materials', 'public'); 
        } else {
            $path = $this->video_url;
        }

        // Create the database entry
        Material::create([
            'title' => $this->title,
            'level' => $this->level,
            'type' => $this->type,
            'content_url' => $path,
        ]);

        session()->flash('message', 'Material successfully uploaded!');
        
        // Reset the form
        $this->reset(['title', 'file_upload', 'video_url']);
    }

    public function render()
    {
        return view('livewire.material-form');
    }
}