@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="dicussion row">
            <div class="col-md-9 col-md-offset-1">
                <form class="form-horizontal" action="{{ url('discussion') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" id="title" name="title" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tag</label>
                        <div class="col-sm-10">
                            <select class="select" multiple="multiple" name="tags[]" style="width: 100%">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Content</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="12" name="content"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success pull-right">发起新讨论</button>
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
