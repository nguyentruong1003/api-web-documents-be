@if(checkButtonCanView('wait_approve'))
<button type="button" wire:click="waiting_appraisal" data-dismiss="modal"  class="btn btn-save">{{__('common.button.submit_aprrove')}}</button>
@endif