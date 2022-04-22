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
                </div>
                
                <div>
                    <div class="input-group">
                        @include('livewire.common.buttons._create')
                    </div>
                </div>
            </div>
            {{-- <div wire:loading class="loader"></div> --}}
            <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead class="">
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Danh mục cha</th>
                        <th>Danh mục con</th>
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
                            <td>{{ $row->parent->name ?? '' }}</td>
                            <td>
                                @if (isset($row->childen))
                                @foreach($row->childen as $value)
                                    <span>{{ $value->name }}</span><br>
                                @endforeach
                                @endif
                            </td>
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
        <div class="modal-dialog" role="document">
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
                                @error('name')@include('layouts.partials.text._error')@enderror
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
