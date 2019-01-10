@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3>打赏我</h3>

                    <h6>如果你觉得该项目对你有助，不妨打赏我一下，这样我就有更大的动力去完善它，优化它。</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row text-center donate">
            <img src="{{ url('images/wechat.jpeg') }}" width="250">
            <img src="{{ url('images/alipay.jpg') }}" width="250">
        </div>
    </div>
@endsection

@section('styles')
<style>
.donate img {
    margin: 30px 50px;
}
</style>
@endsection
