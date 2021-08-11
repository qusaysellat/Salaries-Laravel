@extends('layouts.app')
@section('title')
    edit Position
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">راتب أساسي جديد</p> </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('positions.update',['position'=>$position->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group{{ $errors->has('salary') ? ' has-error' : '' }}">
                                <label for="salary" class="col-md-4 control-label">الراتب الأساسي الجديد</label>

                                <div class="col-md-6">
                                    <input id="salary" type="text" class="form-control" name="salary" value="{{ old('salary') }}" required autofocus>

                                    @if ($errors->has('salary'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('salary') }}</strong>
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
