@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">修改密码</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/changePassword') }}">
                        {!! csrf_field() !!}

                        <div class="form-group row{{ $errors->has('old_passwprd') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label">原来密码</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="old_passwprd" value="{{ $old_passwprd or old('old_passwprd') }}">

                                @if ($errors->has('old_passwprd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old_passwprd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label">新密码</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label">确认密码</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group" style="text-align: center">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i>修改密码
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
