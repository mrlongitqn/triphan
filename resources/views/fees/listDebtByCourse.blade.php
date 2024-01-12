 <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.css"
          integrity="sha512-EzrsULyNzUc4xnMaqTrB4EpGvudqpetxG/WNjCpG6ZyyAGxeB6OBF9o246+mwx3l/9Cn838iLIcrxpPHTiygAA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
          integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
          integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
          crossorigin="anonymous"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous"/>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
          integrity="sha512-aEe/ZxePawj0+G2R+AaIxgrQuKT68I28qh+wgLrcAJOz3rxCP+TwrK5SPN+E5I+1IQjNtcfvb96HDagwrKRdBw=="
          crossorigin="anonymous"/>

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
</head>

<body>

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
            <h3 style="text-align: center">DANH SÁCH NỢ THEO LỚP {{$courseModel->course}}</h3>
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
                        Số tháng
                    </td>
                    <td>
                        Tháng nợ bắt đầu
                    </td>

                </tr>
                </thead>
                <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($result as $student)
                    <tr>
                        <td align="center">{{$i++}}</td>
                        <td>{{$student->fullname}}</td>
                        <td>{{date('d/m/Y', strtotime($student->dob) )}}</td>
                        <td>{{$student->parent_phone1 }}</td>
                        <td>{{$student->debt_month_num}}</td>
                        <td>{{$student->debt_month_start->format('m-Y')}}</td>
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
