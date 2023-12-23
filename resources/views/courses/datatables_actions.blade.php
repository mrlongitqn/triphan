{!! Form::open(['route' => ['courses.destroy', $id], 'method' => 'delete', 'class'=>'text-center']) !!}
<div class='btn-group'>
    <a href="{{ route('courses.show', $id) }}" title="Xem danh sách học viên" class='btn btn-default btn-xs'>
        <i class="fas fa-user-friends"></i>
    </a>
    <a href="{{ route('courses.show', $id) }}" title="In danh sách học viên" class='btn btn-default btn-xs'>
        <i class="fa fa-print"></i>
    </a>
{{--    <a href="{{ route('courses.changeStatus', $id) }}" class='btn btn-default btn-xs'>--}}
{{--        <i class="fa fa-edit"></i>--}}
{{--    </a>--}}
    <a href="{{ route('courses.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Bạn chắc chắn xóa lớp học?')"
    ]) !!}
</div>
{!! Form::close() !!}
