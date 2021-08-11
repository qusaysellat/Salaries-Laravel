@extends('layouts.app')
@section('title')
    {{$organization->name}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">{{$organization->name}}</p> </div>

                    <div class="panel-body">
                        <p class="h4">تقرير عن المدفوعات الشهرية في {{$bname}} ، {{$pname}}</p>
                        <table class="table table-bordered table-condensed table-responsive" style="font-size: 150%;">
                            <tr>
                                <td class="active">
                                    عدد الموظفين
                                </td>
                                <td>
                                    {{ $cnt }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    المدفوعات الإجمالية
                                </td>
                                <td>
                                    {{ $total2 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    المدفوعات الأساسية
                                </td>
                                <td>
                                    {{ $total1}}
                                </td>
                            </tr>
                        </table>

                        @foreach($info as $bid=>$positions)
                            <p class="h5">اسم الفرع : {{ $positions[0]}}</p>
                            @foreach($positions as $pid=>$details)
                                @if($pid==0)
                                    @continue
                                @endif
                                <p class="h6">اسم المستوى الوظيفي : {{$details[0]}}</p>
                                <table class="table table-bordered table-condensed table-responsive" style="font-size: 150%;">
                                    <tr>
                                        <td class="active">
                                            عدد الموظفين
                                        </td>
                                        <td>
                                            {{ $details['empcnt'] }}
                                        </td>
                                    </tr>

                                </table>

                            @endforeach
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
