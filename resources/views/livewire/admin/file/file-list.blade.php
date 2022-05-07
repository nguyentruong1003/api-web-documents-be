<div class="body-content p-2">
    <div class="card">
        <div class="card-body p-2">
            <div class="filter d-flex align-items-center justify-content-between mb-2">
            </div>
            <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead class="">
                    <tr>
                        <th>STT</th>
                        <th>Tên file</th>
                        <th>Url</th>
                        <th>Model Name</th>
                        <th>Model Id</th>
                        <th>Size</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $row)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{!! boldTextSearch($row->file_name, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->url, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->model_name, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->model_id, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->size_file, $searchTerm) !!}</td>
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
</div>
