<div class="row">
    <div class="col-6">Thời gian:</div>
    <div class="col-6"><strong>{{$refund->created_at->format('H:i d/m/Y')}}</strong></div>

    <div class="col-6">Số tiền đã thu:</div>
    <div class="col-6"><strong>{{number_format($refund->total)}} </strong></div>
    <div class="col-6">Số tiền hoàn trả:</div>
    <div class="col-6"><strong>{{number_format($refund->amount)}}</strong></div>
    <div class="col-6">Lý do hoàn trả:</div>
    <div class="col-6"><strong>{{$refund->reason}}</strong></div>
    <div class="col-6">Người hoàn trả:</div>
    <div class="col-6"><strong>{{$user->name}}</strong></div>
    <hr/>
    <table class="table table-stripe">
        <tr>
            <th>Mã HĐ</th>
            <th>Ngày thu</th>
            <th>Khóa học</th>
            <th>Số tiền</th>
            <th>Ghi chú</th>
        </tr>
        @foreach($fees as $fee)
            <tr>
                <td>{{$fee->fee_code}}</td>
                <td>{{$fee->created_at->format('H:i m/d/Y')}}</td>
                <td>{{$fee->course}}</td>
                <td>{{number_format($fee->amount)}}</td>
                <td>{{$fee->note}}</td>
            </tr>
        @endforeach
    </table>
</div>
