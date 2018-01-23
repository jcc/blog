<div class="user jumbotron jumbotron-fluid">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 text-center">
                <img class="avatar rounded-circle" src="{{ $user->avatar }}">
            </div>
            <div class="col-sm-5 content">
                <div class="header">
                    {{ $user->nickname or $user->name }}
                </div>
                <div class="description">
                    {{ $user->description or lang('Nothing') }}
                </div>
                @if(Auth::check())
                    <div class="actions">
                        @can('update', $user)
                            <a href="{{ url('user/profile') }}" class="btn btn-info btn-sm">{{ lang('Edit Profile') }}</a>
                        @endif
                        @if(Auth::id() != $user->id)
                            <a  href="javascript:void(0)"
                                class="btn btn-{{ Auth::user()->isFollowing($user->id) ? 'warning' : 'danger' }} btn-sm"
                                onclick="event.preventDefault();
                                         document.getElementById('follow-form').submit();">
                                {{ Auth::user()->isFollowing($user->id) ? lang('Following') : lang('Follow') }}
                            </a>

                            <form id="follow-form" action="{{ url('user/follow', [$user->id]) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    </div>
                @endif
                <div class="footer">
                    @if($user->github_name)
                    <a class="btn btn-sm btn-primary" target="_blank" href="https://github.com/{{ $user->github_name }}" data-toggle="tooltip" data-placement="top" title="{{ $user->name }}'s Github">
                        <i class="fab fa-github"></i>
                    </a>
                    @endif
                    @if($user->website)
                    <a class="btn btn-sm btn-primary" target="_blank" href="{{ $user->website }}" data-toggle="tooltip" data-placement="top" title="{{ $user->name }}'s Website">
                        <i class="fas fa-globe"></i>
                    </a>
                    @endif
                </div>
            </div>
            <div class="col-sm-5 user-follow">
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{ url("user/{$user->name}/following") }}" class="counter">{{ $user->followings()->count() }}</a>
                        <a href="{{ url("user/{$user->name}/following") }}" class="text">{{ lang('Following Num') }}</a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ url("user/{$user->name}/discussions") }}" class="counter">{{ $user->discussions->count() }}</a>
                        <a href="{{ url("user/{$user->name}/discussions") }}" class="text">{{ lang('Discussion Num') }}</a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ url("user/{$user->name}/comments") }}" class="counter">{{ $user->comments->count() }}</a>
                        <a href="{{ url("user/{$user->name}/comments") }}" class="text">{{ lang('Comment Num') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
