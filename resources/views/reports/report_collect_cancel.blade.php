@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thống kê hủy học phí</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" id="exportExcel"
                       href="javascript:">
                        Xuất excel
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row">


{{--                        <div class="col-3">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="user">Nhân viên</label>--}}
{{--                                <select id="user" name="selectedUsers[]" class="form-control select2" multiple>--}}
{{--                                    @foreach($listUser as $user)--}}
{{--                                        <option @if(in_array($user->id, $selectedUsers)) selected--}}
{{--                                                @endif value="{{$user->id}}">{{$user->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-3">

                            <div class="form-group">
                                <label for="datetime">Thời gian</label>
                                <div class="input-group">
                                    <div class="input-group-prepend" id="datetimePick">
                                        <span class="input-group-text">
                                         <i class="fa fa-caret-down"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" name="datetime" id="datetime"
                                           value="{{$datetime}}">
                                </div>

                            </div>

                        </div>

                        <div class="col-1">
                            <div style="margin-top: 32px">
                                <button class="btn btn-default"><i class="fa fa-filter"></i> Lọc</button>
                            </div>
                        </div>
                    </div>
                </form>
                <table id="tableFee" class="table table-striped">
                    <tr>
                        <th>STT</th>
                        <th>Người thu</th>
                        <th>Thời gian</th>
                        <th>Học viên</th>
                        <th>Khóa học</th>
                        <th>Số tiền</th>
                        <th>Lý do hủy</th>
                    </tr>
                    @if(count($data)==0)
                        <tr>
                            <td colspan="7" style="text-align: center">Chưa có dữ liệu</td>
                        </tr>
                    @endif
                    @php
                        $i =1;
                        $total = 0;
                    @endphp
                    @foreach($data as $item)
                        @php
                            $reason = json_decode($item->reason);
                            $total = $total+$item->amount;
                        @endphp
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$listUser->find($reason->user_id)->name}}</td>
                            <td>{{$item->created_at->format('H:i d/m/Y')}}</td>
                            <td>{{$item->fullname}}</td>
                            <td>{{$item->course}}</td>
                            <td style="text-align: right">{{number_format($item->amount)}}</td>
                            <td>{{$reason->reason}}</td>
                        </tr>
                    @endforeach

                </table>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        Tổng tiền: <strong> {{ number_format($total)}}</strong>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('third_party_scripts')
    <script type="text/javascript" src="{{asset('vendor/tableToExcel.js')}}"></script>
    <script>
        $('#exportExcel').on('click', function () {
            TableToExcel.convert(document.getElementById("tableFee"));
        });

        $('#user').select2({});
        $('#datetimePick').daterangepicker(
            {
                maxDate: moment(),
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày qua': [moment().subtract(6, 'days'), moment()],
                    '30 ngày qua': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                locale: {
                    applyLabel: "Đồng ý",
                    cancelLabel: 'Hủy',
                    customRangeLabel: 'Tùy chỉnh'
                }
            },
            function (start, end) {

                $('#datetime').val(start.format('DD/MM/Y') + ' - ' + end.format('DD/MM/Y'));
            }
        )
    </script>
@endpush
