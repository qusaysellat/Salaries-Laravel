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
                            <p class="h3">اسم الفرع : {{ $positions['0']}}</p>
                            @foreach($positions as $pid=>$details)
                                @if($pid==0)
                                    @continue
                                @endif
                                <p class="h4">اسم المستوى الوظيفي : {{$details['0']}}</p>
                                <table class="table table-bordered table-condensed table-responsive" style="font-size: 150%;">
                                    <tr>
                                        <td class="active">
                                            عدد الموظفين
                                        </td>
                                        <td>
                                            {{ $details['empcnt'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="active">
                                            المدفوعات الإجمالية
                                        </td>
                                        <td>
                                            {{ $details['total2'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="active">
                                            المدفوعات الأساسية
                                        </td>
                                        <td>
                                            {{ $details['total1']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="active">
                                            إجمالي الإضافات والضرائب الخاصة بالمستوى الوظيفي
                                        </td>
                                        <td>
                                            {{ $details['totalposchanges'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="active">
                                            إجمالي الإضافات والحسميات الخاصة بالموظفين
                                        </td>
                                        <td>
                                            {{ $details['totalempchanges']}}
                                        </td>
                                    </tr>
                                </table>

                                <p class="h4">تأثير الإضافات والضرائب الخاصة بالمستوى بالتفصيل: </p>
                                    <table class="table table-bordered table-condensed table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">اسم الإضافة/الضريبة</th>
                                            <th class="text-center">النوع</th>
                                            <th class="text-center">نسبة مئوية؟</th>
                                            <th class="text-center">القيمة</th>
                                            <th class="text-center">القيمة بالليرة</th>
                                            <th class="text-center">الإجمالي</th>
                                        </tr>
                                        </thead>
                                        @foreach($details['poschanges'] as $change)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$change['name']}}</td>
                                                <td>
                                                    @if($change['type']==0)
                                                        إضافة
                                                    @else
                                                        حسمية
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($change['percentage']==0)
                                                        لا
                                                    @else
                                                        نعم
                                                    @endif
                                                </td>
                                                <td>{{$change['value']}}</td>
                                                <td>
                                                    {{$change['realvalue']}} ل.س.
                                                </td>
                                                <td>
                                                    {{$change['finalvalue']}} ل.س.
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                @if(isset($details['empchanges']))
                                        <p class="h4">تأثير الإضافات والحسميات الخاصة بالموظفين بالتفصيل: </p>
                                        <table class="table table-bordered table-condensed table-striped table-responsive">
                                            <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">اسم الموظف</th>
                                                <th class="text-center">اسم الإضافة/الحسمية</th>
                                                <th class="text-center">النوع</th>
                                                <th class="text-center">نسبة مئوية؟</th>
                                                <th class="text-center">القيمة</th>
                                                <th class="text-center">القيمة بالليرة</th>
                                            </tr>
                                            </thead>
                                            @foreach($details['empchanges'] as $change)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$change['emp']}}</td>
                                                    <td>{{$change['name']}}</td>
                                                    <td>
                                                        @if($change['type']==0)
                                                            إضافة
                                                        @else
                                                            حسمية
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($change['percentage']==0)
                                                            لا
                                                        @else
                                                            نعم
                                                        @endif
                                                    </td>
                                                    <td>{{$change['value']}}</td>
                                                    <td>
                                                        {{$change['realvalue']}} ل.س.
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif
                            @endforeach
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
