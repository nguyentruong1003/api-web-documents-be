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
            </div>
            {{-- <div wire:loading class="loader"></div> --}}
            <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead class="">
                    <tr>
                        <th>STT</th>
                        <th>Bài viết</th>
                        <th>Người báo cáo</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $row)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.post.show', ['id' => $row->post_id]) }}" target="_blank" style="color: black">
                                    {{ $row->post->title ?? '' }}
                                </a>
                            </td>
                            <td>{{ $row->user->name ?? '' }}</td>
                            <td>{!! boldTextSearch($row->description, $searchTerm) !!}</td>
                            <td>
                                @if ($row->resolve == 1)
                                    <span class="badge badge-warning">Chờ xử lý</span>
                                @else
                                    <span class="badge badge-success">Đã xử lý</span>
                                @endif
                            </td>
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
    @include('livewire.common.modal._modalDelete')
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
                    @if ($check)
                        Bạn có muốn đánh dấu phản hồi này là đã giải quyết hay không?
                    @else
                        Bạn có muốn đánh dấu phản hồi này là chưa giải quyết hay không?
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal" wire:click.prevent="resetInputFields"
                            class="btn btn-secondary close-btn" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" wire:click="resolve" class="btn btn-primary close-modal">Xác nhận</button>
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
