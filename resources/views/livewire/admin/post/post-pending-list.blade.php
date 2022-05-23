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
                        <th>Trạng thái</th>
                        <th>Hành động</th>
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
                            <td>{{ $row->status == 0 ? 'Từ chối' : 'Chờ duyệt' }}</td>
                            <td>
                                <button type="button" class="btn-sm border-0 bg-transparent"
                                    data-toggle="modal" data-target="#confirmModal"
                                    wire:click="check({{$row->id}})">
                                    <i class="fas fas fa-check"></i>
                                </button>
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

    <div wire:ignore.self class="modal fade" id="confirmModal" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body container-fluid">
                    Bạn có muốn phê duyệt bài viết này hay không?
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal-confirm" wire:click.prevent="resetInputFields"
                            class="btn btn-secondary close-btn" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" wire:click="approve" class="btn btn-primary close-modal">Phê duyệt</button>
                    <button type="button" wire:click="decline" class="btn btn-warning close-modal">Từ chối</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.livewire.on('close-modal', () => {
            $('#close-modal-confirm').click();
        });
    </script>
</div>
