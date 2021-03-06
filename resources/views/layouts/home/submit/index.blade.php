@extends('layouts.app')
@section('title', 'Trà lời thử thách')
@section('customcss')
<link rel="stylesheet" href="{{ asset('css\categories.css') }}">
@endsection
@section('customscript')
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
<script src="{{ asset('js/posts.js') }}"></script>
@endsection
@section('activeBaiviet', 'active')
@section('content')
<div class="row ms-0 me-0 w-100">
    <div class="col-md-12 ps-0 pe-0">
        <form class="form-horizontal px-0" method="POST" enctype="multipart/form-data">
            <div class="row ms-0 me-0 w-100">
                <div class="col-md-8 ps-1 pe-1">
                    <div class="card border-primary mb-2">
                        <div class="card-header bg-light">
                            <p class="m-0">
                                <a href="{{route('postsManage.index')}}">Thử thách</a> /
                            </p>
                            <h3 class="inline">{{$chall->title}}</h3>
                        </div>
                        <div class="card-body">
                            {{ csrf_field() }}
                            <div class="form-outline mb-3">
                                <label class="form-label" for="formtitlehelp">Trả lời</label>
                                <input type="text" id="title" class="form-control @error('title') is-invalid @enderror"
                                    aria-describedby="titlehelp" name="answer"
                                    placeholder="vd: Tài liệu Nhập môn Mạng máy tính" onchange="textAutoLink()"
                                    required />
                            </div>
                            <div id="titlehelp" class="form-text">
                                @error('title')
                                <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-4 ps-1 pe-1">
                    <div class="card border-primary mb-2" style="min-height: 100px">
                        <div class="card-header bg-light">Kết quả</div>

                        <small id="slugHelp" class="form-text"> @error('imgfile')
                            <div class="text-danger pb-1 mb-2">{{ $message }}</div>
                            @enderror
                        </small>
                        <button type="submit" id="submit" class="btn btn-primary" name="submit">Nộp bài</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection