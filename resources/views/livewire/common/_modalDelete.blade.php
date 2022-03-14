<div wire:ignore.self class="modal fade" id="exampleDelete" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body box-user">
                <button class="btn float-right" data-dismiss="modal"><em class="fa fa-times"></em></button>
                <h4 class="modal-title">{{ __('common.confirm_message.confirm_title') }}</h4>
                {{ __('common.confirm_message.are_you_sure_delete') }}
            </div>
            <div class="group-btn2 text-center pt-24">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">{{ __('common.button.cancel') }}</button>
                <button type="button" wire:click.prevent="delete()" class="btn btn-save" data-dismiss="modal">{{ __('common.button.delete') }}</button>
            </div>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body box-user">
                <button class="btn float-right" data-dismiss="modal"><em class="fa fa-times"></em></button>
                <h4 class="modal-title" id="exampleModalLabel">{{ __('common.confirm_message.confirm_title') }}</h4>
                <div class="mt-3">{{ __('common.confirm_message.are_you_sure_delete') }}</div>
            </div>
            <div class="group-btn2 text-center pt-24">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">{{ __('common.button.cancel') }}</button>
                <button type="button" class="btn btn-save" data-dismiss="modal" wire:click="delete()">{{ __('common.button.delete') }}</button>
            </div>
        </div>
    </div>
</div>
