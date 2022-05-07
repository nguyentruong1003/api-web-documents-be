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
                                <label>Tên<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" wire:model.lazy="name">
                                @error('name')@include('layouts.partials.text._error')@enderror
                            </div>

                            <div class="form-group">
                                <label> Danh sách module chức năng </label>
                                <div class="group-permissions">
                                    @foreach ($permissions as $moduleName => $values)
                                        <div class="mb-2">
                                            <div class="bg-light p-2 d-flex align-items-center justify-content-between" style="cursor: pointer" onclick="openModule('{{ $moduleName }}')">
                                                <span>
                                                    <div class="toggle">
                                                        <input type="checkbox" class="toggle-checkbox checkbox-module-name" id="toggle-{{ $moduleName }}">
                                                        <label class="toggle-label" for="toggle-{{ $moduleName }}" 
                                                            {{-- data-toggle="collapse" data-target="#{{ $moduleName ?? 'default' }}" --}}
                                                            ><i class="fas fas fa-angle-right toggle-chevron"></i></label>
                                                    </div>
                                                    {!! $listNameMenu[$moduleName] ?? $moduleName !!}
                                                </span>
                                            </div>
                                            <div id="{{ $moduleName }}" class="collapse">
                                                <table class="table">
                                                    <tbody>
                                                        @foreach ($values as $grant)
                                                            <tr>
                                                                <td>{{ $listNameGrant[$grant['action']] ?? $grant['action'] }}</td>
                                                                <td class="w-40">
                                                                    <label class="switch">
                                                                        <input type="checkbox" class="toggle-checkbox grant" id="grant-{{ $grant['id'] ?? 0 }}" value="{{ $grant['id'] ?? 0 }}" @if (in_array($grant['id'] ?? 0, $selectedPermissions)) checked @endif>
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal" wire:click.prevent="resetInputFields"
                            class="btn btn-secondary close-btn" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" onclick="submit()" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("document").ready(() => {
            $('#create-update-modal').on('show.bs.modal', function(){
                $('.checkbox-module-name').each(function() {
                    $(this).prop("checked", false);
                });
            });
        });
        window.livewire.on('close-modal', () => {
            $('#close-modal').click();
        });

        function openModule(moduleName) {
            if ($("#toggle-" + moduleName).is(':checked')) {
                $("#toggle-" + moduleName).prop("checked", false);
                $("#" + moduleName).slideUp();
            } else {
                $("#toggle-" + moduleName).prop("checked", true);
                $("#" + moduleName).slideDown();
            }
        }
    
        function submit() {
            let selectedPermissions = [];
            $('.grant:checked').each(function() {
                selectedPermissions.push(this.value);
            });
            @this.selectedPermissions = selectedPermissions;
            
            @this.save();
        }
    </script>
</div>
