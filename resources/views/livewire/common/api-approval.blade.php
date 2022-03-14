<div class="form-approval">
    <form id="formSubmitApproval" method="POST" action="{{ $urlApproval }}" enctype="multipart/form-data">
        <input type="hidden" name="token" wire:model.lazy="token" />
        <input type="hidden" name="callback" wire:model.lazy="url" />
        <input type="hidden" name="type" value="inner" />
        <input type="hidden" name="formname" value="basic form" />
        <input type="hidden" name="subject" wire:model.lazy="subject" />
        <input type="hidden" name="content" wire:model.lazy="content" />
    </form>
</div>

<script>
    $("document").ready(function() {
        $('.buttonSendApproval').on('click', function () {
            window.livewire.emit('saveDataSendApproval');
        });

        window.livewire.on('submit-form-approval', () => {
            document.getElementById('formSubmitApproval').submit();
        });
    });
</script>
