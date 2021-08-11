@extends('layouts.app')
@section('title')
    edit Branch
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">مدير رواتب جديد للفرع</p> </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('branches.update',['branch'=>$branch->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group{{ $errors->has('manager') ? ' has-error' : '' }}">
                                <label for="manager" class="col-md-4 control-label">اسم مدير رواتب الفرع</label>

                                <div class="col-md-6">
                                    <input id="manager" type="text" class="form-control" name="manager" value="{{ old('manager') }}" required autofocus>

                                    @if ($errors->has('manager'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('manager') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">اسم المستخدم لمدير رواتب الفرع</label>

                                <div class="col-md-6">
                                    <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">كلمة المرور لمدير رواتب الفرع</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">تأكيد كلمة المرور</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        حفظ
                                    </button>
                                </div>
                            </div>
                        </form>
                        <a href="{{route('branches.index')}}">
                            <button type="button" class="btn btn-success">
                                تراجع
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
