<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('notification.member.warning.warning')}}</h5>
            </div>
            <div class="modal-body">
                {{__('notification.member.warning.Do you want to export excel file?')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{__('common.button.back')}}</button>
                <button type="button" wire:click="export" class="btn btn-primary" data-dismiss="modal" id='btn-upload-film' download>{{__('common.button.export_file')}}</button>
            </div>
        </div>
    </div>
</div>
