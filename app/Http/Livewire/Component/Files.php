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
        'saveFile'
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

        // $this->validate();
        $fileUpload = new File();
        $fileUpload->url = $this->file->storeAs('public/files/' . auth()->id(), $this->file->getFilename());
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
        $this->reset();
    }

    public function deleteFile($id)
    {
        $data = File::find($id);
        if (!empty($data)) {
            // $path = public_path(). '/storage/'. substr($data->url, 7, strlen($data->url) - 7);
            // if (file_exists($path)) {
            //     unlink($path);
            // }
            $data->delete();
        }
    }

    public function deleteUnknownFiles()
    {
        File::query()->where('admin_id', auth()->id())->whereNull('model_id')->delete();
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
        $file = File::findorfail($id);
        return Storage::download($file->url);
    }
}
