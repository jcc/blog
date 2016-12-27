@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="dicussion row">
            <div class="col-md-9 col-md-offset-1">
                <form class="form-horizontal" action="{{ url('discussion', ['id' => $discussion->id]) }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" id="title" name="title" value="{{ $discussion->title }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tag</label>
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
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="12" name="content">{{ json_decode($discussion->content)->raw }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success pull-right">修改讨论</button>
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
