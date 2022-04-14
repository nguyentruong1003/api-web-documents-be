<?php

namespace App\Editors;

use App\Models\PostType;

class FileEditor extends Editor
{

    public function handleSave()
    {
        $this->model->fill([
            'url' => $this->file->storeAs('public/files/' . auth()->id(), $this->file->getFilename()),
            'size_file' => getFileSize($this->file),
            'file_name' => $this->file->getClientOriginalName(),
            'model_name' => $this->model_name,
            'model_id' => $this->model_id,
            'admin_id' => auth()->check() ? auth()->id() : null,
        ]);
        $this->model->save();
    }
}
