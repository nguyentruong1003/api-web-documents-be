@if(checkButtonCanView('approve'))
<button type="button" wire:click="approved" data-dismiss="modal" class="btn btn-fix btn-fix-primary w-100 h-52 justify-content-center body-3">{{__('common.button.approve_content')}}</button>
@endif