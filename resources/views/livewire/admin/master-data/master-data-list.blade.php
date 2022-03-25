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
                        <a href="#" data-toggle="modal" data-target="#create-update-modal" id="create-button" wire:click="create">
                            <div class="btn-sm btn-primary">
                                <i class="fa fa-plus"></i> TẠO MỚI
                            </div>
                        </a>
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
                        <th>Hành động</th>
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
                            <td>
                                <a href="#" data-toggle="modal" data-target="#create-update-modal" wire:click="edit({{ $row->id }})"
                                        class="btn-sm border-0 bg-transparent">
                                        <img src="/images/pent2.svg" alt="Edit">
                                </a>
                                @include('livewire.common.buttons._delete')
                            </td>
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
    @include('livewire.common._modalDelete')

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
                                @error('v_key')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Giá trị<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" wire:model.lazy="v_value">
                                @error('v_value')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Thể loại<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" wire:model.lazy="type">
                                @error('type')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Thứ tự ưu tiên</label>
                                <input type="text" class="form-control" wire:model.lazy="order_number">
                                @error('order_number')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Giá trị cha</label>
                                <input type="text" class="form-control" wire:model.lazy="parent_id">
                                @error('parent_id')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <input type="text" class="form-control" wire:model.lazy="v_content">
                                @error('v_content')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Ghi chú</label>
                                <input type="text" class="form-control" wire:model.lazy="note">
                                @error('note')<div class="text-danger mt-1">{{$message}}</div>@enderror
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
