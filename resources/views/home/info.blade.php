@extends('html.bootstrap4')

@section('title', $title)

@section('content')
            <div class="row align-items-center">
                <div class="col text-center">
                    <h1>{{$title}}</h1>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <ul class="list-group">
                        <li class="list-group-item">網址：{{$url}}</li>
                        <li class="list-group-item">目的：{{$go_url}}</li>
                        <li class="list-group-item">訪問：{{$access}}</li>
                        <li class="list-group-item">期限：{{$expire_at}}</li>
                    </ul>
                </div>
            </div>
@endsection
