<?php

namespace App\Http\Livewire\Component;

use App\Http\Livewire\Base\BaseLive;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Files extends BaseLive
{

    use WithFileUploads;
    public $name;
    public $file;
    public $url;
    public $model_name;
    public $model_id;
    public $file_name;
    public $canUpload = true;
    public $canDownload = true;
    public $uploadOnShow = 0;
    public $deleteUnknownFilesOnMount = true;
    public $disabled;
    public $list = [];

    public $maximumFileSize = 255; // Mb
    public $maximumUploads = 5;
    public $acceptMimeTypes;

    public $files = [];

    protected $listeners = [
        'setModelId',
        'saveFile',
        'delete-file' => 'emitDeleteFile',
    ];

    public function mount()
    {
        // if (empty($this->acceptMimeTypes)) {
        //     $this->acceptMimeTypes = config('common.mime_type.general', []);
        // }

        if (empty($this->name)) {
            $this->name = 'Đính kèm file';
        }

        if($this->deleteUnknownFilesOnMount) {
            $this->deleteUnknownFiles();
        }
    }

    public function render()
    {
        $this->files = File::query()
            ->where('model_name', $this->model_name)
            ->where('model_id', $this->model_id)
            ->get()
            ->keyBy('id')
            ->toArray();

        if ($this->uploadOnShow == 0 && checkShowMode()) {
            $this->canUpload = false;
        }
        return view('livewire.component.files');
    }

    public function setModelId($model_id = null) {
        $this->model_id = $model_id;
    }

    public function updatedFile()
    {

        $this->validate([
            'file' => [
                'mimes:pdf',
                'max:' . $this->maximumFileSize * 1024
            ],
        ], [
            'file.mime' => 'only accept pdf files'
        ]);
        $fileUpload = new File();
        $fileUpload->url = $this->file->storeAs('/', $this->file->getClientOriginalName(), 'google');
        $fileUpload->size_file = $this->getFileSize($this->file);
        $fileUpload->file_name = $this->file->getClientOriginalName();
        $fileUpload->model_name = $this->model_name;
        $fileUpload->model_id = $this->model_id;
        $fileUpload->admin_id = auth()->check() ? auth()->id() : null;
        $fileUpload->save();
        if ($this->model_id == null)
            $this->list[] = $fileUpload->id;
    }

    public function saveFile($model_id) {
        if ($this->list) {
            foreach ($this->list as $id) {
                File::findorfail($id)->update([
                    'model_id' => $model_id
                ]);
            }
        }
        $this->reset(['model_id', 'list']);
    }

    public function deleteFile($id)
    {
        $data = File::find($id);
        if (!empty($data)) {
            $file = getFileOnGoogleDriveServer($id);
            if (isset($file)) {
                Storage::disk('google')->delete($file['path']);
                $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => 'File was deleted from Google Drive']);
            } else {
                $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => 'File not found on Google Drive. Deleted file from system']);
            }
            $data->delete();
        }
    }

    public function deleteUnknownFiles()
    {
        $files = File::query()->where('admin_id', auth()->id())->whereNull('model_id')->get();
        foreach ($files as $data) {
            $file = getFileOnGoogleDriveServer($data->id);
            if (isset($file)) {
                Storage::disk('google')->delete($file['path']);
            }
            $data->delete();
        }
    }

    public function getFileSize($file) {
        $bytes = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function download($id)
    {
        # code...
        $file = getFileOnGoogleDriveServer($id);
        if (isset($file)) {
            $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => 'Download file successfully']);
            return Storage::disk('google')->download($file['path']);
        } else {
            $this->dispatchBrowserEvent('show-toast', ['type' => 'error', 'message' => 'File not found on Google Drive']);
        }
    }

    public function emitDeleteFile($model_name, $model_id)
    {
        # code...
        $files = File::where('model_name', $model_name)->where('model_id', $model_id)->get();
        foreach ($files as $file) {
            $this->deleteFile($file->id);
        }
    }
}
