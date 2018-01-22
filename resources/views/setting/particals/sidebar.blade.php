<div class="card card-info">
    <div class="card-header">{{ lang('Settings') }}</div>

    <div class="list-group list-group-flush">
        <a href="{{ url('setting') }}" class="list-group-item {{ isActive('setting.index') }}">
            <i class="ion-ios-barcode-outline"></i>{{ lang('Account Setting') }}
        </a>
        @if(config('blog.mail_notification'))
        <a href="{{ url('setting/notification') }}" class="list-group-item {{ isActive('setting.notification') }}">
            <i class="ion-android-notifications-none"></i>{{ lang('Notification Setting') }}
        </a>
        @endif
        <a href="{{ url('setting/binding') }}" class="list-group-item {{ isActive('setting.binding') }}">
            <i class="ion-lock-combination"></i>{{ lang('Account Binding') }}
        </a>
    </div>
</div>