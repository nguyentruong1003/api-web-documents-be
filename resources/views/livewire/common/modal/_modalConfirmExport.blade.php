
      <!-- Modal export /-->
      <div class="modal fade" id="export-modal" tabindex="-1" aria-labelledby="delete-department-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <strong>
                <h5 class="modal-title" id="delete-department-modal-label">{{__('notification.member.warning.warning')}}</h5>
              </strong>
            </div>
            <div class="modal-body">
              {{__('notification.member.warning.Do you want to export excel file?')}}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-cancel" data-dismiss="modal">{{__('common.button.back')}}</button>
              <button type="button" class="btn btn-save" data-dismiss="modal" wire:click="export">{{__('common.button.export_file')}}</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal export /-->
