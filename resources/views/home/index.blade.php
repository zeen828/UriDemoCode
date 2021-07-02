@extends('html.bootstrap4')

@section('title', '短網址產生器')

@section('content')
            <div class="row align-items-center">
                <div class="col text-center">
                    <h1>短網址產生器</h1>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                <form method="post" action="/">
                    {{csrf_field()}}
                    <label for="url">URL:</label>
                    <input type="url" name="url" id="url" class="form-control" required>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </from>
                </div>
            </div>
@if (!empty($url))
            <div class="row align-items-center">
                <div class="col text-center">
                    <h1>短網址</h1>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <ul class="list-group">
                        <li class="list-group-item">網址：<a href="{{$url}}">{{$url}}</a></li>
                        <li class="list-group-item">分析：<a href="{{$urlInfo}}">{{$urlInfo}}</a></li>
                        <li class="list-group-item">目的：{{$go_url}}</li>
                        <li class="list-group-item">訪問：{{$access}}</li>
                        <li class="list-group-item">期限：{{$expire_at}}</li>
                    </ul>
                </div>
            </div>
@endif
@endsection
