{!! Form::open(['route' => ['students.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('students.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('students.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    <a target="_blank" href="{{ route('fees.collect', $id) }}" class='btn btn-default btn-xs' title="Thu học phí">
        <i class="fas fa-money-bill"></i>
    </a>
    <a target="_blank" href="{{ route('reports.ReportTotal', $id) }}" class='btn btn-default btn-xs' title="In bảng tổng hợp">
        <i class="far fa-file-alt"></i>
    </a>
{{--    <a href="{{ route('students.edit', $id) }}" class='btn btn-default btn-xs' title="Xem lịch học">--}}
{{--        <i class="fas fa-calendar-alt"></i>--}}
{{--    </a>--}}
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
