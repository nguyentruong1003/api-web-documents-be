<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('common.confirm_message.confirm_title') }}</h3>
            </div>
            <div class="modal-body">
                {{ __('common.confirm_message.are_you_sure_delete') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('common.button.cancel') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="delete()">{{ __('common.button.delete') }}</button>
            </div>
        </div>
    </div>
</div>