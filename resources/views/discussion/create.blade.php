@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="dicussion row">
            <div class="col-md-9 offset-md-1">
                <form class="form" action="{{ url('discussion') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">{{ lang('Discuss Title') }}</label>
                        <div class="col-sm-10">
                            <input type="text" id="title" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">

                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ lang('Discuss Tag') }}</label>
                        <div class="col-sm-10">
                            <select class="select{{ $errors->has('tags') ? ' is-invalid' : '' }}" multiple="multiple" name="tags[]" style="width: 100%">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('tags'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('tags') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="content" class="col-sm-2 col-form-label">{{ lang('Discuss Content') }}</label>
                        <div class="col-sm-10">
                            <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" id="content" rows="12" name="content">{{ old('content') }}</textarea>

                            @if ($errors->has('content'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success float-right" onClick="this.form.submit(); this.disabled=true;">{{ lang('Create Discussion') }}</button>
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
