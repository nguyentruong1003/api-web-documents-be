<div wire:ignore.self class="modal fade" id="create-update-modal" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @if(!$checkEdit) Thêm mới
                    @else Chỉnh sửa
                    @endif
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tiêu đề<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control" wire:model.lazy="title">
                            @error('title')@include('layouts.partials.text._error')@enderror
                        </div>

                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" class="form-control" wire:model.lazy="description">
                        </div>

                        <div class="form-group">
                            <label>Thể loại<span class="text-danger"> *</span></label>
                            <select wire:model.lazy="post_type_id" class="form-control-sm form-control custom-input-control article-type">
                                @foreach ($types as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('post_type_id')@include('layouts.partials.text._error')@enderror
                        </div>

                        <div class="form-group">
                            <label>Nội dung</label>
                            <div class="form-group" wire:ignore>
                                <textarea id="content" name="content" rows="3" wire:model.lazy="content" class="textarea form-control" id="somenote"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>File đính kèm</label>
                            @livewire('component.files', ['model_name' => $model_name])
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close-modal" wire:click.prevent="resetInputFields"
                        class="btn btn-secondary close-btn" data-dismiss="modal">Đóng
                </button>
                <button type="button" wire:click="save" class="btn btn-primary close-modal">Lưu</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        window.livewire.on('set-content', (content) => {
            $('#content').summernote('code', content);
        });
        $('#content').summernote({
            callbacks: {
                onChange: function(contents, $editable) {
                    @this.set('content', contents);
                }
            }
        });
    });
</script>