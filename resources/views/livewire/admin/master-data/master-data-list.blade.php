<div class="body-content p-2">
    <div class="card">
        <div class="card-body p-2">
            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group search-expertise">
                            <div class="search-expertise inline-block">
                                <input type="text" placeholder="Tìm kiếm" name="search"
                                    class="form-control" id='input_vn_name' autocomplete="off" wire:model.debounce.1000ms="searchTerm">
                            </div>
                        </div>
                    </div>

                    <div wire:ignore class="col-md-6">
                        <select wire:model.debounce.1000ms="searchType" class="form-control">
                            <option value="">
                                -- Chọn thể loại --
                            </option>
                            {{-- @foreach (\App\Enums\EMasterData::getListData() as $id => $value)
                                <option value="{{ $id }}">{{ $value }}</option>
                            @endforeach --}}
                        </select>
                    </div>

                </div>
                
                <div>
                    <div class="input-group">
                        @include('livewire.common.buttons._create')
                    </div>
                </div>
            </div>
            <div wire:loading class="loader"></div>
            <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead class="">
                    <tr>
                        <th>STT</th>
                        <th>Từ khóa</th>
                        <th>Giá trị</th>
                        <th>Thứ tự ưu tiên</th>
                        <th>Thể loại</th>
                        <th>Giá trị cha</th>
                        <th>Nội dung</th>
                        <th>Ghi chú</th>
                        @if (checkRoutePermission('edit') || checkRoutePermission('delete'))
                        <th>Hành động</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $row)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{!! boldTextSearch($row->v_key, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->v_value, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->order_number, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->type, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->parent_id, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->v_content, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->note, $searchTerm) !!}</td>
                            @if (checkRoutePermission('edit') || checkRoutePermission('delete'))
                            <td>
                                @include('livewire.common.buttons._edit')
                                @include('livewire.common.buttons._delete')
                            </td>
                            @endif
                        </tr>
                    @empty
                        <td colspan='12' class='text-center'>Không tìm thấy dữ liệu</td>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(count($data))
            {{ $data->links() }}
        @endif
    </div>
    @include('livewire.common.modal._modalDelete')

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
                                <label>Từ khóa<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" wire:model.lazy="v_key">
                                @error('v_key')@include('layouts.partials.text._error')@enderror
                            </div>

                            <div class="form-group">
                                <label>Giá trị<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" wire:model.lazy="v_value">
                                @error('v_value')@include('layouts.partials.text._error')@enderror
                            </div>

                            <div class="form-group">
                                <label>Thể loại<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" wire:model.lazy="type">
                                @error('type')@include('layouts.partials.text._error')@enderror
                            </div>

                            <div class="form-group">
                                <label>Thứ tự ưu tiên</label>
                                <input type="text" class="form-control" wire:model.lazy="order_number">
                                @error('order_number')@include('layouts.partials.text._error')@enderror
                            </div>

                            <div class="form-group">
                                <label>Giá trị cha</label>
                                <input type="text" class="form-control" wire:model.lazy="parent_id">
                                @error('parent_id')@include('layouts.partials.text._error')@enderror
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <input type="text" class="form-control" wire:model.lazy="v_content">
                                @error('v_content')@include('layouts.partials.text._error')@enderror
                            </div>

                            <div class="form-group">
                                <label>Ghi chú</label>
                                <input type="text" class="form-control" wire:model.lazy="note">
                                @error('note')@include('layouts.partials.text._error')@enderror
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
        window.livewire.on('close-modal', () => {
            $('#close-modal').click();
        });
    </script>
</div>
