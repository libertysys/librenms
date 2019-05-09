@extends('layouts.librenmsv1')

@section('title', __('Preferences'))

@section('content')
<div class="container">
    <row>
        <legend>@lang('User Preferences')</legend>
    </row>

    @if($can_change_password)
    <div class="panel panel-default panel-condensed">
        <div class="panel-heading">@lang('Change Password')</div>
        <div class="panel-body">
            <form method="post" action="preferences/" class="form-horizontal" role="form">
                <input type=hidden name="action" value="changepass">
                <div class="form-group">
                    <label for="old_pass" class="col-sm-4 control-label">@lang('Current Password')</label>
                    <div class="col-sm-4">
                        <input type="password" name="old_pass" autocomplete="off" class="form-control input-sm">
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_pass" class="col-sm-4 control-label">@lang('New Password')</label>
                    <div class="col-sm-4">
                        <input type="password" name="new_pass" autocomplete="off" class="form-control input-sm">
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_pass2" class="col-sm-4 control-label">@lang('New Password')</label>
                    <div class="col-sm-4">
                        <input type="password" name="new_pass2" autocomplete="off" class="form-control input-sm">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-3">
                        <button type="submit" class="btn btn-default">@lang('Change Password')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    @endif

    <div class="panel panel-default panel-condensed">
        <div class="panel-heading">@lang('User Preferences')</div>
        <div class="panel-body">
            <form method="post" action="{{ route('preferences.store') }}" class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="dashboard" class="col-sm-4 control-label">@lang('Dashboard')</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="dashboard" id="dashboard-select" data-previous="{{ $default_dashboard }}">
                            @foreach($dashboards as $dash)
                                <option value="{{ $dash->dashboard_id }}" @if($dash->dashboard_id == $default_dashboard) selected @endif>{{ $dash->user ? $dash->user->username : __('<deleted>') }}:{{ $dash->dashboard_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dashboard" class="col-sm-4 control-label">@lang('Add schedule notes to devices notes')</label>
                    <div class="col-sm-4">
                        <input id="notetodevice" type="checkbox" name="notetodevice" @if($note_to_device) checked @endif>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @config('twofactor')
    <div class="panel panel-default panel-condensed">
        <div class="panel-heading">@lang('Two-Factor Authentication')</div>
        <div class="panel-body">
        @if($twofactor)
            <div id="twofactorqrcontainer">
                <div id="twofactorqr"></div>
                <script>$("#twofactorqr").qrcode({"text": "{{ $twofactor_uri }}"});</script>
                <button class="btn btn-default" onclick="$('#twofactorkeycontainer').show(); $('#twofactorqrcontainer').hide();">@lang('Manual')</button>
            </div>
            <div id="twofactorkeycontainer">
                <form id="twofactorkey" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="twofactorkey" class="col-sm-4 control-label">@lang('Secret Key')</label>
                        <div class="col-sm-4">
                            <input type="text" name="twofactorkey" autocomplete="off" disabled class="form-control input-sm" value="{{ $twofactor['key'] }}" />
                        </div>
                    </div>
                    @if($twofactor['counter'] !== false)
                    <div class="form-group">
                        <label for="twofactorcounter" class="col-sm-4 control-label">@lang('Counter')</label>
                        <div class="col-sm-4">
                            <input type="text" name="twofactorcounter" autocomplete="off" disabled class="form-control input-sm" value="{{ $twofactor['counter'] }}" />
                        </div>
                    </div>
                    @endif
                </form>
                <button class="btn btn-default" onclick="$('#twofactorkeycontainer').hide(); $('#twofactorqrcontainer').show();">@lang('QR')</button>
            </div>
                <br/>
                <form method="post" class="form-horizontal" role="form" action="{{ route('2fa.remove') }}">
                    <button class="btn btn-danger" type="submit">@lang('Disable TwoFactor')</button>
                </form>
        @else
            <form method="post" class="form-horizontal" role="form" action="{{ route('2fa.add') }}">
                <div class="form-group">
                    <label for="twofactortype" class="col-sm-4 control-label">@lang('TwoFactor Type')</label>
                    <div class="col-sm-4">
                        <select name="twofactortype" class="select form-control">
                            <option value="time">@lang('Time Based (TOTP)')</option>
                            <option value="counter">@lang('Counter Based (HOTP)')</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-3">
                        <button class="btn btn-default" type="submit" id="twofactor-generate">@lang('Generate TwoFactor Secret Key')</button>
                    </div>
                </div>
            </form>
        @endif
        </div>
    </div>
    @endconfig

    <div class="panel panel-default panel-condensed">
        <div class="panel-heading">@lang('Device Permissions')</div>
        <div class="panel-body">
            <strong class="blue">Global Administrative Access</strong>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ asset('js/jquery.qrcode.min.js') }}"></script>
    @endsection

@section('scripts')
    <script>
        $("[name='notetodevice']")
            .bootstrapSwitch('offColor', 'danger')
            .on('switchChange.bootstrapSwitch', function (e, state) {
                var $this = $(this);
                $.ajax({
                    url: '{{ route('preferences.store') }}',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'changenote',
                        state: state ? 1 : 0
                    },
                    success: function () {
                        $this.closest('.form-group').addClass('has-success');
                        setTimeout(function () {
                            $this.closest('.form-group').removeClass('has-success');
                        }, 2000);
                    },
                    error: function () {
                        $this.bootstrapSwitch('toggleState', true);
                        $this.closest('.form-group').addClass('has-error');
                        setTimeout(function(){
                            $this.closest('.form-group').removeClass('has-error');
                        }, 2000);
                    }
                });
            });

        $('#dashboard-select').change(function () {
            var $this = $(this);
            var value = $this.val();
            $.ajax({
                url: '{{ route('preferences.store') }}',
                dataType: 'json',
                type: 'POST',
                data: {
                    action: 'changedash',
                    dashboard: value
                },
                success: function () {
                    $this.data('previous', value);
                    toastr.success('@lang('Dashboard updated')');
                    $this.closest('.form-group').addClass('has-success');
                    setTimeout(function () {
                        $this.closest('.form-group').removeClass('has-success');
                    }, 2000);
                },
                error: function () {
                    $this.val($this.data('previous'));
                    toastr.error('@lang('Failed to update dashboard ')');
                    $this.closest('.form-group').addClass('has-error');
                    setTimeout(function(){
                        $this.closest('.form-group').removeClass('has-error');
                    }, 2000);
                }
            });
        });
    </script>
@endsection

@section('css')
    <style>
        #twofactorkeycontainer { display: none; }
    </style>
@endsection
