<div class="body-content p-2">
    <div class="p-2">
        {{ $data->description }}
    </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <div class="container">
                    {!! $data->content !!}
                </div>
            </div>
            <div wire:loading class="loader"></div>
        </div>
        
    </div>
</div>
