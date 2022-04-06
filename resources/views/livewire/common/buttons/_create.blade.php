@if (checkRoutePermission('create'))
<button type="button" data-toggle="modal" data-target="#create-update-modal" title="{{__('common.button.create')}}" class="btn-sm btn-primary" wire:click="create"><i class="fa fa-plus"></i> TẠO MỚI</button>
@endif
