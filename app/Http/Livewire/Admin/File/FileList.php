<?php

namespace App\Http\Livewire\Admin\File;

use App\Http\Livewire\Base\BaseLive;
use App\Models\File;
use Livewire\Component;

class FileList extends BaseLive
{
    public function render()
    {
        $query = File::query();
        $data = $query->orderBy('created_at','desc')->paginate($this->perPage);

        return view('livewire.admin.file.file-list', ['data' => $data]);
    }
}
