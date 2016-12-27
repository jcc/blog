<ul class="list-group">
    @forelse($discussions as $discussion)
        <li class="list-group-item">
            <a href="{{ url('discussion', ['id' => $discussion->id]) }}">{{ $discussion->title }}</a>
            <span class="meta">
                in <span class="timeago">{{ $discussion->created_at->diffForHumans() }}</span>
            </span>
        </li>
    @empty
        <li class="nothing">{{ lang('Nothing') }}</li>
    @endforelse
</ul>