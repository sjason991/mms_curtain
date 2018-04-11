@extends('home')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">编辑  <p>订单：WQ{{$id}}</p></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <add-order ord="{{$id}}" sta="{{$status}}"></add-order>
    </div>
@endsection