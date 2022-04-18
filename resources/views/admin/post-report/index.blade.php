@extends('layouts.master')
@section('title')
    <title>Danh sách phản hồi</title>
@endsection
@section('content')
    <div class="body-content p-2">
        <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
            <div class="">
                <h4 class="m-0">
                    Danh sách phản hồi
                </h4>
            </div>
            <div class="paginate">
                <div class="d-flex">
                    <div class="">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                    </div>
                    <span class="px-2">/</span>
                    <div class="">
                        <div class="disable">Quản lý bài viết</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   @livewire('admin.post-report.post-report-list')
@endsection