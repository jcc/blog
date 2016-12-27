@extends('layouts.app')

@section('content')
<div class="container profile">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <div class="cover-avatar text-center">
                <form action="{{ url('user/avatar') }}" id="avatar" method="POST"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <img class="avatar" src="{{ $user->avatar }}">
                    <input type="file" id="image" name="avatar" style="outline: none;">
                </form>
                <span class="help-block">{{ lang('Update Notice') }}</span>
                <span id="validate-errors"></span>
            </div>
        </div>
        <div class="col-md-7">
            <form action="{{ url('user/profile', ['id' => $user->id]) }}" method="POST" class="form-horizontal">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <fieldset>
                    <div class="form-group">
                        <label for="Name" class="col-md-3 control-label">{{ lang('Username') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Name" value="{{ $user->name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Email" class="col-md-3 control-label">{{ lang('Email') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Email" value="{{ $user->email }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Nickname" class="col-md-3 control-label">{{ lang('Nickname') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Nickname" name="nickname" value="{{ $user->nickname }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Website" class="col-md-3 control-label">{{ lang('Website') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Website" name="website" value="{{ $user->website }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Weibo" class="col-md-3 control-label">{{ lang('Weibo Name') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Weibo" name="weibo_name" value="{{ $user->weibo_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Weibo" class="col-md-3 control-label">{{ lang('Weibo Home') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Weibo" name="weibo_link" value="{{ $user->weibo_link }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="GitHub" class="col-md-3 control-label">GitHub</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="GitHub" name="github" value="{{ $user->github_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Description" class="col-md-3 control-label">{{ lang('Description') }}</label>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="3" name="description" id="Description">{{ $user->description }}</textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-action row">
                        <div class="col-md-offset-3 col-md-9 col-xs-12">
                            <button class="btn btn-success btn-block" type="submit">{{ lang('Update Profile') }}</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cropAvatar" tabindex="1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('/crop/api') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">Crop Avatar</h4>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="crop-image-wrapper" style="width: 400px;margin: 0 auto;">
                            <img src="{{ config('blog.default_avatar') }}" id="cropBox" style="width: 100%">
                            <input type="hidden" id="photo" name="photo">
                            <input type="hidden" id="x" name="x">
                            <input type="hidden" id="y" name="y">
                            <input type="hidden" id="w" name="w">
                            <input type="hidden" id="h" name="h">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">保存图片</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ elixir('css/jcrop.css') }}">
<style>
    .modal {
        overflow: hidden !important;
    }
    .modal-body {
        overflow: scroll;
    }
</style>
@endsection

@section('scripts')
    <script src="{{ elixir('js/jcrop.js') }}"></script>

    <script>
        $(document).ready(function () {
            var options = {
                beforeSubmit: showRequest,
                success     : showResponse,
                dataType    : 'json'     
            };
            $('#image').on('change', function () {
                $('#avatar').ajaxForm(options).submit();
            });
        });
        function showRequest() {
            $('#validate-errors').hide().empty();
            return true;
        }
        function showResponse(response) {
            if(response.success == false) {
                var responseErrors = response.errors;
                $.each(responseErrors, function (index, value) {
                    if(value.length != 0) {
                        $('#validate-errors').append('<div class="alert alert-error"><strong>'+value+'</strong></div>');
                    }
                });
                $('#validate-errors').show();
            }else {
                var cropBox = $('#cropBox');
                cropBox.attr('src', response.avatar);
                $('#photo').val(response.image);
                $('#cropAvatar').modal();
                cropBox.Jcrop({
                    aspectRatio : 1,
                    onChange    : updateCoords,
                    boxWidth    : 500,
                    setSelect   : [0, 0, 400, 400]
                });
                $('.jcrop-holder img').attr('src', response.avatar);
            }
        }
        function updateCoords(c)
        {
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        }
    </script>
@stop
