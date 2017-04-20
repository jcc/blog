<?php
$user = App\User::find($notification->data['id']);
?>

<li :class="'{{ empty($notification->read_at) }}' ? 'bold' : ''">
    @if ($user)
        <a class="text-info" href="{{ url('user', [ 'username' => $user->name ]) }}">{{ $user->name }}</a> {{ lang('Followed') }}
    @else
        <s>{{ lang('User') }} {{ lang('Deleted') }}</s>
    @endif
</li>
