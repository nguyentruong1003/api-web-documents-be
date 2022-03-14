@if($checkCreatePermission)
<a data-toggle="modal" id="show_modal_create" wire:click="resetInputFields" title="{{__('common.button.create')}}" data-target="#createModal" class="btn btn-viewmore-news mr0 text-white" href="">
    <img src="/images/plus2.svg" alt="plus">
    {{__('data_field_name.research_plan.create')}}
</a>
@endif
