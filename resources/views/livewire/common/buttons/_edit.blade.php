<!-- open popup -->
@if($checkEditPermission)
<button type="button" data-toggle="modal" id="show_modal_edit" data-target="#target" title="{{__('common.button.edit')}}" wire:click="edit({{ $row->id }})" class="btn-sm border-0 bg-transparent mr-1 show_modal_edit"><img src="/images/edit.png" alt="edit"></button>
@endif
