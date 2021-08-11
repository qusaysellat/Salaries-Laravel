@extends('layouts.app')
@section('title')
    New Change
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">املأ الحقول التالية بشكل صحيح</p> </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('pchanges.store') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="position_id" value="{{$position_id}}">

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">اسم الإضافة/الضريبة</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }} radio">

                                <div class="col-md-6  col-md-offset-4">
                                    <div class="row">
                                    <label dir="ltr" class="col-xs-offset-2 col-xs-4"><input id="type" type="radio" class="" name="type" value="0" required > إضافة </label>
                                    <label dir="ltr" class="col-xs-4"><input id="type" type="radio" class="" name="type" value="1" required > ضريبة </label><br/>
                                    </div>
                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('percentage') ? ' has-error' : '' }} radio">

                                <div class="col-md-6  col-md-offset-4">
                                    <div class="row">
                                    <label dir="ltr" class="col-xs-offset-2 col-xs-4"><input id="percentage" type="radio" class="" name="percentage" value="0" required > ليرة سورية </label>
                                    <label dir="ltr" class="col-xs-4"><input id="percentage" type="radio" class="" name="percentage" value="1" required > نسبة مئوية </label><br/>
                                    </div>
                                    @if ($errors->has('percentage'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('percentage') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <br/>
                            <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                                <label for="value" class="col-md-4 control-label">القيمة</label>

                                <div class="col-md-6">
                                    <input id="value" type="text" class="form-control" name="value" value="{{ old('value') }}" required autofocus>

                                    @if ($errors->has('value'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                                    @endif
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
                        <a href="{{route('positions.index')}}">
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
