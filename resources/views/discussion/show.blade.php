@extends('layouts.app')

@section('title', $discussion->title)

@section('content')
    @component('particals.jumbotron')
        <h4>{{ $discussion->title }}</h4>

        <span><i class="ion-person" style="margin-right: 10px"></i>{{ $discussion->user->name or 'null' }}</span><br/>

        @can('update', $discussion)
            <a href="{{ url("discussion/{$discussion->id}/edit") }}" class="edit-discuss btn btn-info btn-sm"><i class="ion-edit" style="padding: 0"></i> {{ lang('Edit Problem') }}</a>
        @endcan
    @endcomponent

    <div class="discuss-show container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="media">
                    <div class="media-body box-body">
                        <div class="heading">
                            <i class="ion-clock"></i>{{ lang('Published At') }} : {{ $discussion->created_at }}&nbsp;&nbsp;&nbsp;&nbsp;
                            <i class="ion-chatbubble-working"></i>{{ lang('Replies Num') }} : {{ $discussion->comments->count() }}
                        </div>
                        <div class="discuss-body">
                            <parse content="{{ json_decode($discussion->content)->raw }}"></parse>
                        </div>
                        @if(config('blog.social_share.discussion_share'))
                        <div class="footing">
                            <div class="social-share"
                                data-title="{{ $discussion->title }}"
                                data-description="{{ $discussion->title }}"
                                {{ config('blog.social_share.sites') ? "data-sites=" . config('blog.social_share.sites') : '' }}
                                {{ config('blog.social_share.mobile_sites') ? "data-mobile-sites=" . config('blog.social_share.mobile_sites') : '' }}
                                initialized></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::guest())
        <comment commentable-type="discussions"
                 commentable-id="{{ $discussion->id }}"
                 null-text=""></comment>
    @else
        <comment username="{{ Auth::user()->name }}"
                 user-avatar="{{ Auth::user()->avatar }}"
                 commentable-type="discussions"
                 commentable-id="{{ $discussion->id }}"
                 null-text=""
                 can-comment></comment>
    @endif
@endsection

@section('scripts')
    <script>
        hljs.initHighlightingOnLoad();
    </script>
@endsection