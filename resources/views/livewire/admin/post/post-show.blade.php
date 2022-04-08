<div class="body-content p-2">
    <div class=" row p-2">
        <div class="col col-md-2">{{ $data->description }}</div>
        <div class="col">{{ $data->created_at ? $data->created_at->diffForHumans() : '' }}</div>
    </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <div class="filter d-flex align-items-center justify-content-between mb-2 w-100">
                <div class="container">
                    {!! $data->content !!}
                </div>
            </div>
        </div>
        <div class="card-body p-2">
            <div class="container">
                @livewire('component.files', ['model_name' => $model_name, 'disabled' => true, 'name' => "File đính kèm"])
            </div>
        </div>
        <div class="card-body p-2">
            <div class="container">
                @livewire('component.comments', ['post_id' => $data->id])
            </div>
        </div>
    </div>
</div>
