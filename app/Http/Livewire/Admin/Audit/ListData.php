<?php

namespace App\Http\Livewire\Admin\Audit;

use App\Http\Livewire\Base\BaseLive;
use Illuminate\Support\Facades\Config;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Support\Carbon;

class ListData extends BaseLive
{
    public $userList = [];
    public $searchUser;
    public $from_date;
    public $to_date;

    public function render() {
    	$data = $this->searchData();
        return view('livewire.admin.audit.list-data', ['data' => $data]);
    }

    public function searchData() {
        $query = Audit::query();
        if (strlen($this->searchTerm)) {
            $searchTerm = $this->searchTerm;
        	$query->where(function($q) use ($searchTerm) {
                $q->whereRaw('lower(user_type) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(user_id) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(event) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(auditable_type) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(auditable_id) like ?', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(old_values) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(new_values) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(url) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(ip_address) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(user_agent) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(tags) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%'])
                    ->orWhereRaw('lower(note) like ? ', ['%' . trim(mb_strtolower($searchTerm, 'UTF-8')) . '%']);
            });
        }
        if (!empty($this->searchUser)) {
            if ($this->searchUser == 'none') {
                $query->where('user_id', null);
            } else
                $query->where('user_id', $this->searchUser);
        }
        if(!is_null($this->from_date)) {
            $query->where('created_at', '>=', $this->from_date);
        }
        if(!is_null($this->to_date)) {
            $query->where('created_at', '<=', Carbon::parse($this->to_date)->endOfDay());
        }
        $data = $query->orderBy('id','DESC')->paginate($this->perPage);
        $tmp = $data->map(function ($item) {
            if (!is_array($item->old_values)) {
                $item->old_values = json_decode($item->old_values);
            }
            if (!is_array($item->new_values)) {
                $item->new_values = json_decode($item->new_values);
            }
            if ($item->user_id) {
                $user = User::findorfail($item->user_id)->first();
                if (!empty($user) && !in_array(['id' => $item->user_id, 'name' => $user->name], $this->userList)) {
                    array_push($this->userList, [
                        'id' => $item->user_id,
                        'name' => $user->name
                    ]);
                }
            }
            
            return [
                'id' => $item->id,
                'perfomer' => !empty($user) ? $user->name : null,
                'event' => $item->event,
                'audittable_type' => $item->auditable_type,
                'audittable_id' => $item->auditable_id,
                'old_values' => $item->old_values,
                'new_values' => $item->new_values,
                'url' => $item->url,
                'ip_address' => $item->ip_address,
                'user_agent' => $item->user_agent,
                'note' => $item->note,
                'created_at' => Carbon::parse($item->created_at),
            ];
        });
        $data->setCollection($tmp);
        return $data;
    }
}