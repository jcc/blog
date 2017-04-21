@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="dicussion row">
            <div class="col-md-9 col-md-offset-1">
                <form class="form-horizontal" action="{{ url('discussion', ['id' => $discussion->id]) }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-sm-2 control-label">{{ lang('Discuss Title') }}</label>
                        <div class="col-sm-10">
                            <input type="text" id="title" name="title" class="form-control" value="{{ $discussion->title }}">

                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">{{ lang('Discuss Tag') }}</label>
                        <div class="col-sm-10">
                            <select class="select" multiple="multiple" name="tags[]" style="width: 100%">
                                @foreach($tags as $tag)
                                    @if(in_array($tag->id, $selectTags))
                                        <option value="{{ $tag->id }}" selected>{{ $tag->tag }}</option>
                                    @else
                                        <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @if ($errors->has('tags'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tags') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                        <label for="content" class="col-sm-2 control-label">{{ lang('Discuss Content') }}</label>
                        <div class="col-sm-10">
                            <parse-textarea content="{{ json_decode($discussion->content)->raw }}"></parse-textarea>

                            @if ($errors->has('content'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success pull-right" onClick="this.form.submit(); this.disabled=true;">{{ lang('Edit Discussion') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $('.select').select2();
</script>
@endsection

@section('styles')
<style>
    .dicussion {
        margin-top: 40px;
    }
</style>
@endsection
