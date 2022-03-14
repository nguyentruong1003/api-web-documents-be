<div class="body-content p-2">
    <div class="card">
        <div class="card-body p-2">
            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group search-expertise">
                            <div class="search-expertise inline-block">
                                <input type="text" placeholder="Tìm kiếm" name="search"
                                    class="form-control" id='input_vn_name' autocomplete="off" wire:model.debounce.1000ms="searchTerm">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="input-group">
                        <a href="#" data-toggle="modal" data-target="#create-update-modal" wire:click="resetInputFields()" id="create-button">
                            <div class="btn-sm btn-primary">
                                <i class="fa fa-plus"></i> TẠO MỚI
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead class="">
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $row)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{!! boldTextSearch($row->name, $searchTerm) !!}</td>
                            <td>{{ ReFormatDate($row->created_at,'d-m-Y') }}</td>
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
                                <label>Tên<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" wire:model.lazy="name">
                                @error('name')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Quyền</label>
                                <div wire:ignore>
                                    <select class="form-control select2" multiple style="width: 100%" wire:model.lazy="permission">
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div> 
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
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Chọn quyền ..."
            });
            $('.select2').on('change', function (e) {
                let data = $(this).val();
                 @this.set('permission', data);
            });
            window.livewire.on('set-permissions', () => {
                $('.select2').select2();
            });
        });
    </script>
</div>
