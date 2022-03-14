<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-body box-user">
                <h4 class="modal-title">{{__('common.confirm_message.confirm_title')}}</h4>
                <button class="btn float-right" style="position: absolute; top: 0px; right: 0px;" data-dismiss="modal"><em class="fa fa-times"></em></button>
                {{__('common.confirm_message.are_you_sure_delete')}}
            </div>
            <div class="group-btn2 text-center pt-24">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('common.button.cancel')}}</button>
                <button type="button" wire:click.prevent="delete()" class="btn btn-primary"
                data-dismiss="modal">{{__('common.button.delete')}}</button>
            </div>
        </div>
    </div>
</div>
