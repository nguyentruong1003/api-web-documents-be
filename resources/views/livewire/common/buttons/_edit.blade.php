@if (checkRoutePermission('edit'))
<button type="button" data-toggle="modal" data-target="#create-update-modal" title="{{__('common.button.edit')}}" wire:click="edit({{ $row->id }})" class="btn-sm border-0 bg-transparent"><img src="/images/pent2.svg" alt="Edit"></button>
@endif
