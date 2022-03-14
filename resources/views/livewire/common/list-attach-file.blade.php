<div class="col-md-12 list-file px-16 mt-5">
    @if (!empty($listFile))
        <div class="row">
            <label class="text-title" class="px-16">{{ __('data_field_name.approval_topic.list_attach_file') }}</label>
            <div class="table-responsive px-16">

                <div class="border border-light border-top-0 p-3 rounded-bottom file-list">
                    @foreach($listFile as $key => $file)
                        <div class="d-inline-flex mr-2 mb-2 p-2 bg-light align-items-center rounded">
                            <img src="/images/File.svg" alt="file" width="50px">
                            <div>
                                <a href="{{ route('api.gw-approval.download', [$file['docu_no'], $file['file_no']]) }}" target="_blank">{{ $file['name'] }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

