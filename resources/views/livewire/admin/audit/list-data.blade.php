<div class="body-content p-2">
    <div class="card">
        <div class="card-body p-2">
            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group search-expertise">
                            <div class="search-expertise inline-block">
                                <input type="text" placeholder="Tìm kiếm" name="search"
                                    class="form-control" id='input_vn_name' autocomplete="off" wire:model.debounce.1000ms="searchTerm">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div>
                            <select wire:model.debounce.1000ms="searchUser" class="form-control">
                                <option value="">
                                    --Người tác động--
                                </option>
                                <option value="none">&ltunknown&gt</option>
                                @foreach($userList as $item)
                                    <option value="{{$item['id']}}">
                                        {{$item['name']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <input type="date" class="form-control" name="fromDate" wire:model.debounce.1000ms="from_date" autocomplete="off">
                    </div>

                    <div class="col-md-2">
                        <input type="date" class="form-control" name="toDate" wire:model.debounce.1000ms="to_date" autocomplete="off">
                    </div>
                </div>
            </div>
            
            <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead class="">
                    <tr>
                        <th>Người tác động</th>
                        <th>Thao tác</th>
                        <th>Loại bảng Audit</th>
                        {{-- <th>ID bảng Audit</th> --}}
                        {{-- <th>Giá trị cũ</th> --}}
                        {{-- <th>Giá trị mới</th> --}}
                        <th>Ngày tác động</th>
                        {{-- <th>URL</th> --}}
                        <th>Địa chỉ IP</th>
                        {{-- <th>Tác nhân</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $row)
                        <tr>
                            <td class="text-left">{!! boldTextSearch($row['perfomer'], $searchTerm) !!}</td>
                            <td class="text-left">{!! boldTextSearch($row['event'], $searchTerm) !!}<br>
                                <a href="" data-toggle="modal" data-target="{{'#show' . $row['id']}}">
                                    Chi tiết ...
                                </a>
                                @include('livewire.admin.audit._detailModal')
                            </td>
                            <td class="text-left">{!! boldTextSearch($row['audittable_type'], $searchTerm) !!}</td>
                            {{-- <td class="text-left">{!! boldTextSearch($row['audittable_id'], $searchTerm) !!}</td> --}}
                            {{-- <td class="text-left">
                                @if(!empty($row['old_values']) && count($row['old_values']) > 0)
                                    @foreach($row['old_values'] as $index => $item)
                                        <p class="mb-1 content-audit-data" title='{!!$index.": ".json_encode($item)!!}'><span class="font-weight-bold">{{$index}}</span>: {!! boldTextSearch(json_encode($item), $searchTerm) !!}</p>
                                    @endforeach
                                @endif
                            </td> --}}
                            {{-- <td class="text-left">
                                @if(!empty($row['new_values']) && count($row['new_values']) > 0)
                                    @foreach($row['new_values'] as $index => $item)
                                        <p class="mb-1 content-audit-data" title='{{$index.": ".json_encode($item)}}'><span class="font-weight-bold">{{$index}}</span>: {!! boldTextSearch(json_encode($item), $searchTerm) !!}</p>
                                    @endforeach
                                @endif
                            </td> --}}
                            <td class="text-left">{!! reFormatDate($row['created_at'], 'd/m/Y') !!}</td>
                            {{-- <td class="text-left">
                                <p class="mb-1 content-audit-data">{!! boldTextSearch($row['url'], $searchTerm) !!}</p>
                            </td> --}}
                            <td class="text-left">{!! boldTextSearch($row['ip_address'], $searchTerm) !!}</td>
                            {{-- <td class="text-left">
                                <p class="mb-1 content-audit-data">{!! boldTextSearch($row['user_agent'], $searchTerm) !!}</p>
                            </td> --}}
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