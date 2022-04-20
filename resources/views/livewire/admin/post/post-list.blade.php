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
                            @foreach ($types as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                        <th>Thể loại</th>
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
                            <td>
                                @if (checkRoutePermission('show'))
                                <a href="{{ route('admin.post.show', ['id' => $row->id]) }}" style="color: black">
                                    {!! boldTextSearch($row->title, $searchTerm) !!}
                                </a>
                                @else
                                    {!! boldTextSearch($row->title, $searchTerm) !!}
                                @endif
                            </td>
                            <td>{!! boldTextSearch($row->description, $searchTerm) !!}</td>
                            <td>{{ ($row->types->name ?? '') }}</td>
                            <td>{{ ReFormatDate($row->created_at,'d-m-Y') }}</td>
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
    @include('livewire.admin.post._modalCreateEdit')

    <script>
        window.livewire.on('close-modal', () => {
            $('#close-modal').click();
        });
    </script>
</div>
