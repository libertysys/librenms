@extends('layouts.librenmsv1')

@section('title', __('Create User'))

@section('content')
<div class="row">
    <form action="users" method="POST" role="form" class="form-horizontal col-sm-offset-3 col-sm-6">
        <legend>@lang('Create User')</legend>

        <div class="form-group @if($errors->has('username')) has-error @endif">
            <label for="realname" class="control-label col-sm-3">@lang('Username')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}">
                <span class="help-block">{{ $errors->first('username') }}</span>
            </div>
        </div>

        @include('user.form')

        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" class="btn btn-primary">@lang('Save')</button>
                <a type="button" class="btn btn-danger" href="{{ route('users.index') }}">@lang('Cancel')</a>
            </div>
        </div>
    </form>
</div>
@endsection
