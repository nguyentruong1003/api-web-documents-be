<?php

namespace App\Http\Livewire\Admin\PostReport;

use App\Http\Livewire\Base\BaseLive;
use App\Models\PostReport;
use Livewire\Component;

class PostReportList extends BaseLive
{
    public $resolveId, $check;

    public function render()
    {
        $query = PostReport::query();

        if ($this->searchTerm) {
            $query->where('unsign_text', 'like', '%' . strtolower(trim(removeStringUtf8($this->searchTerm))) . '%');
        }

        $data = $query->orderBy('created_at','desc')->paginate($this->perPage);
        return view('livewire.admin.post-report.post-report-list', ['data' => $data]);
    }

    public function check($id)
    {
        # code...
        $this->resolveId = $id;
        $pr = PostReport::findorfail($this->resolveId);
        $this->check = ($pr->resolve == 1) ? true : false;
    }

    public function resolve()
    {
        # code...
        $pr = PostReport::findorfail($this->resolveId);
        $pr->resolve = ($pr->resolve == 1) ? 2 : 1;
        $pr->save();
        $this->emit('close-modal');
    }
}
