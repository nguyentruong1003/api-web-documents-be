<div wire:ignore class="modal fade" id="{{'show'. $row['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-upper">Chi tiết</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label class="text-upper">Người tác động</label>
                        <div class="text-left"> 
                            {{$row['perfomer']}}
                        </div>
                    </div>
                    <div class="col">
                        <label class="text-upper">Thao tác</label>
                        <div class="text-left"> 
                            {{$row['event']}}
                        </div>
                    </div>
                    <div class="col">
                        <label class="text-upper">Ngày tác động</label>
                        <div class="text-left"> 
                            {{ reFormatDate($row['created_at'], 'd/m/Y - H:s') }}
                        </div>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col">
                        <label class="text-upper">Loại bảng Audit</label>
                        <div class="text-left"> 
                            {{$row['audittable_type']}}
                        </div>
                    </div>
                    <div class="col">
                        <label class="text-upper">ID bảng Audit</label>
                        <div class="text-left"> 
                            {{$row['audittable_id']}}
                        </div>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-upper">Giá trị cũ</label>
                        <div class="text-left">
                            @if(!empty($row['old_values']) && count($row['old_values']) > 0)
                                @foreach($row['old_values'] as $index => $item)
                                    <p class="mb-1 content-audit-data" title='{{$index.": ".json_encode($item)}}'><span class="font-weight-bold">{{$index}}</span>: {!! boldTextSearch(json_encode($item), $searchTerm) !!}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-upper">Giá trị mới</label>
                        <div class="text-left">
                            @if(!empty($row['new_values']) && count($row['new_values']) > 0)
                                @foreach($row['new_values'] as $index => $item)
                                    <p class="mb-1 content-audit-data" title='{{$index.": ".json_encode($item)}}'><span class="font-weight-bold">{{$index}}</span>: {!! boldTextSearch(json_encode($item), $searchTerm) !!}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col">
                        <label class="text-upper">URL</label>
                        <div class="text-left"> 
                            {{$row['url']}}
                        </div>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col">
                        <label class="text-upper">Địa chỉ IP</label>
                        <div class="text-left"> 
                            {{$row['ip_address']}}
                        </div>
                    </div>
                    <div class="col">
                        <label class="text-upper">Tác nhân</label>
                        <div class="text-left"> 
                            {{$row['user_agent']}}
                        </div>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col">
                        <label class="text-upper">Ghi chú</label>
                        <div class="text-left"> 
                            {{$row['note']}}
                        </div>
                    </div>
                </div><hr>
            </div>
        </div>
    </div>
</div>