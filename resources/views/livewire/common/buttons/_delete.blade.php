@if (checkRoutePermission('delete'))
<button type="button" data-toggle="modal" data-target="#deleteModal" title="{{__('common.button.delete')}}" wire:click="deleteId({{$row->id}})" class="btn-sm border-0 bg-transparent"><img src="/images/trash.svg" alt="Delete"></button>
@endif
