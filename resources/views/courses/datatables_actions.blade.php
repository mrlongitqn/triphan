{!! Form::open(['route' => ['courses.destroy', $id], 'method' => 'delete', 'class'=>'text-center']) !!}
<div class='btn-group'>
    <a href="{{ route('courseStudents.index', $id) }}" title="Xem danh sách học viên" class='btn btn-default btn-xs'>
        <i class="fas fa-user-friends"></i>
    </a>
    <a target="_blank" href="{{route('courseStudents.printList')}}/{{$id}}/on" title="In danh sách học viên"
       class='btn btn-default btn-xs'>
        <i class="fa fa-print"></i>
    </a>
    <a target="_blank" href="{{route('fees.listFeeDebtByCourse')}}/{{$id}}" title="In Danh sách nợ học phí"
       class='btn btn-default btn-xs'>
        <i class="fas fa-money-bill"></i>
    </a>
    <a href="{{ route('courseSessions.index',['course'=>$id]) }}" title="Xem ca học" class='btn btn-default btn-xs'>
        <i class="fas fa-calendar-alt"></i>
    </a>
    <a href="{{ route('courses.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    <a href="{{ route('courses.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    <a href="javascript:;" data-status="{{$status}}" data-href="{{ route('courses.changeStatus', $id) }}" class='btn btn-default btn-xs btn-status'>
        @if($status)
            <i class="fas fa-ban"></i>
        @else
            <i class="fas fa-check"></i>
        @endif
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Bạn chắc chắn xóa lớp học?')"
    ]) !!}
</div>
{!! Form::close() !!}
