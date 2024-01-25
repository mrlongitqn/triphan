@php
    $date = \Carbon\Carbon::parse($fee->created_at);
@endphp
<div class="invoice p-3 mb-3">

    <div class="row">
        <div class="col-12">
            <h4 style="text-align: center">
                <span class="badge {{($fee->status === '0'? 'badge-success': ($fee->status === 1?'badge badge-danger':'badge-warning'))}}">{{($fee->status === '0'? 'ĐÃ THU': ($fee->status === 1?'ĐÃ HỦY':'ĐÃ HOÀN TRẢ'))}}</span></h4>
            <h4 style="text-align: center">CHI TIẾT HĐ: {{$fee->fee_code}}</h4>
            <h6 style="text-align: center">Thời gian thu: {{$date->format('H:i d/m/Y')}}</h6>
            <h6 style="text-align: center">Người thu: {{$user->name}}</h6>

        </div>
    </div>


    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table no-boder">

                <tbody>
                <tr>
                    <td>Họ viên:</td>
                    <td>{{$student->fullname}}</td>

                </tr>
                <tr>
                    <td>Thu HP lớp:</td>
                    <td>{{$course->course}}</td>
                </tr>
                <tr>
                    <td>Nội dung thu:</td>
                    <td>{{$fee_text}}</td>
                </tr>
                <tr>
                    <td>Tổng tiền:</td>
                    <td>{{number_format($fee->total, 0, ',')}}</td>
                </tr>
                <tr>
                    <td>Giảm giá:</td>
                    <td>{{number_format($fee->discount, 0, ',')}}%</td>
                </tr>
                <tr>
                    <td>Số tiền cần thu:</td>
                    <td>{{number_format($fee->amount, 0, ',')}}</td>
                </tr>
                <tr>
                    <td>Bằng chữ:</td>
                    <td>{{$amount_text}}</td>
                </tr>
                <tr>
                    <td>Ghi chú</td>
                    <td>{{$fee->note}}</td>
                </tr>
                </tbody>
            </table>

        </div>
        <h3>Chi tiết thu</h3>
        <div class="col-12 table-responsive">
            <table class="table no-boder">
                <thead>
                <tr>
                    <td>STT
                    </td>
                    <td>Tháng</td>
                    <td>Học phí</td>
                    <td>Tiền thu</td>
                    <td>Ghi chú</td>
                </tr>
                </thead>

                <tbody>
                @foreach($details as $i =>$item)

                    <tr>
                        <td>{{$i+1}}
                        </td>
                        <td>{{$item->month.'/'.$item->year}}</td>
                        <td>{{number_format($item->origin)}}</td>
                        <td>{{number_format($item->amount)}}</td>
                        <td>{{$item->note}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>

    </div>


</div>
