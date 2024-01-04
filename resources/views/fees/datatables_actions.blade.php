
<div class='btn-group'>
    <a title="Xem phiếu thu"  href="javascript:"  onclick="viewDetail('{{$fee_code}}')" class='btn btn-default btn-xs btn-show'>
        <i class="fa fa-eye"></i>
    </a>
    <a title="In phiếu thu" href="javascript:"  onclick="PopupWindow('{{route('fees.getBill', $fee_code)}}','Print',1000,800)" class='btn btn-default btn-xs btn-print'>
        <i class="fa fa-print"></i>
    </a>
    @if($status==0)
        <a title="Hủy hóa đơn" href="javascript:"  data-id="{{$fee_code}}" class='btn btn-danger btn-xs btn-cancel'>
            <i class="fas fa-window-close"></i>
        </a>
    @endif

</div>
