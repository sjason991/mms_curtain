@extends('home')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">支付</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <Bill ord_id="{{$order_id}}"></Bill>
    </div>
@endsection