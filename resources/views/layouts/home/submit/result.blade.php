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
        <div class="card">
            <div class="card-header">{{ __('Bài tập') }}</div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <div class="container">
                    <div class="index-tai-lieu-cover text-uppercase wow fadeInDown {{$status}}" data-wow-delay="0.3s">
                        <h2 class="w-100 text-center py-2 "><b>Kết quả</b></h2>
                    </div>
                    <div class="row">
                        <p class="text-{{$status}}">{{$message}}</p>
                        <b>Nội dung file:</b>
                        <p>{{$anwser}}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection