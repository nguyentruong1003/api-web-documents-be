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
                    @if (checkRoutePermission('create'))
                    <div class="input-group">
                        <a href="#" data-toggle="modal" data-target="#create-update-modal" id="create-button" wire:click="create">
                            <div class="btn-sm btn-primary">
                                <i class="fa fa-plus"></i> TẠO MỚI
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            <div wire:loading class="loader"></div>
            <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead class="">
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        @if (checkRoutePermission('edit') || checkRoutePermission('delete'))
                        <th>Hành động</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $row)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{!! boldTextSearch($row->name, $searchTerm) !!}</td>
                            <td>{{ $row->email }}</td>
                            <td>
                                @foreach($row->roles as $role)
                                    <span>{{ $role->name }}</span><br>
                                @endforeach
                            </td>
                            <td>{{ ReFormatDate($row->created_at,'d-m-Y') }}</td>
                            @if (checkRoutePermission('edit') || checkRoutePermission('delete'))
                            <td>
                                @if (checkRoutePermission('edit'))
                                <a href="#" data-toggle="modal" data-target="#role-modal" wire:click="edit({{ $row->id }})"
                                    class="btn-sm border-0 bg-transparent">
                                    <img src="/images/Duplicate.svg" alt="Edit" title="Phân quyền">
                                </a>
                                <a href="#" data-toggle="modal" data-target="#create-update-modal" wire:click="edit({{ $row->id }})"
                                        class="btn-sm border-0 bg-transparent">
                                        <img src="/images/pent2.svg" alt="Edit" title="Chỉnh sửa">
                                </a>
                                @endif
                                @if (checkRoutePermission('delete'))
                                @include('livewire.common.buttons._delete')
                                @endif
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
                                <label>Email<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" wire:model.lazy="email">
                                @error('email')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>
    
                            <div class="form-group">
                                <label>@if(!$checkEdit) Mật khẩu @else Mật khẩu mới @endif<span class="text-danger"> *</span></label>
                                <input type="password" class="form-control" wire:model.lazy="password">
                                @error('password')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Xác nhận mật khẩu<span class="text-danger"> *</span></label>
                                <input type="password" class="form-control" wire:model.lazy="password_confirmation">
                                @error('password_confirmation')<div class="text-danger mt-1">{{$message}}</div>@enderror
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal-create-update" wire:click.prevent="resetInputFields"
                            class="btn btn-secondary close-btn" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" wire:click="save" class="btn btn-primary close-modal">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="role-modal" role="dialog" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Phân quyền
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" class="form-control" wire:model.lazy="name" disabled>
                            </div>

                            <div class="form-group">
                                <label>Vai trò</label>
                                <div wire:ignore>
                                    <select class="form-control select2" multiple style="width: 100%" wire:model.lazy="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal-role" wire:click.prevent="resetInputFields"
                            class="btn btn-secondary close-btn" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" wire:click="updateRole" class="btn btn-primary close-modal">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.livewire.on('close-modal-create-update', () => {
            $('#close-modal-create-update').click();
        });

        window.livewire.on('close-modal-role', () => {
            $('#close-modal-role').click();
        });

        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Chọn vai trò ..."
            });
            $('.select2').on('change', function (e) {
                let data = $(this).val();
                @this.set('role', data);
            });
            window.livewire.on('set-roles', () => {
                $('.select2').select2();
            });
        });
    </script>
</div>
