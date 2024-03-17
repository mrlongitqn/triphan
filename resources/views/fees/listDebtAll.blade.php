

@extends('layouts.print_layout')

@push('page_css')
    <style>
        body {
            font-family: Roboto, serif;
            font-size: 1.2rem;
        }

        table, tr, td {

            border: 1px solid !important;

        }

        .table td {
            padding: 4px;
            vertical-align: middle;
        }

        .table td p {
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        #footer p {
            margin-bottom: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: bold;
        }

    </style>
@endpush

@section('body')

<div class="invoice p-3 mb-3">

    <div class="row">
        <div class="col-12" style="text-align: center">
            <h2>
                CÔNG TY TNHH GIÁO DỤC TRÍ PHAN
            </h2>
            <h4>
                ĐC: 32-34 Bàu Năng 2, P.Hòa Minh, Q.Liên Chiểu, TP.Đà Nẵng
            </h4>
            <h4>MST: 0401 828 513 * ĐT: 0905 290 857</h4>

        </div>
    </div>

    <div class="row" style="margin-top: 40px">
        <div class="col-12">
            <h3 style="text-align: center">DANH SÁCH NỢ HỌC PHÍ</h3>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr style="background: #5fa2db; font-weight: bold">
                    <td style="text-align: center; width: 50px">
                        STT
                    </td>
                    <td>
                        Họ tên
                    </td>
                    <td>
                        Ngày sinh
                    </td>
                    <td>
                        Điện thoại
                    </td>
                    <td>
                        Điện thoại 2
                    </td>
                    <td>
                        Chi tiết nợ
                    </td>

                </tr>
                </thead>
                <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($students as $student)
                    <tr>
                        <td align="center">{{$i++}}</td>
                        <td>{{$student->fullname}}</td>
                        <td>{{date('d/m/Y', strtotime($student->dob) )}}</td>
                        <td>{{$student->parent_phone1 }}</td>
                        <td>{{$student->parent_phone2 }}</td>
                        <td>
                            @if(isset($courseDebt[$student->id]))
                                @foreach($courseDebt[$student->id] as $item)
                                    <p>
                                        {{$item->course}}: {{number_format($item->debt_amount) }} ({{$item->debt_month_start->format('m-Y')}})
                                    </p>
                                @endforeach
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    setTimeout(function () {
        window.print();
    }, 500);
    window.onfocus = function () {
        setTimeout(function () {
            window.close();
        }, 500);
    }
</script>
</body>
</html>
