{!! Form::open(['route' => ['courses.destroy', $id], 'method' => 'delete', 'class'=>'text-center']) !!}
<div class='btn-group'>
{{--    <a href="{{ route('courses.show', $id) }}" class='btn btn-default btn-xs'>--}}
{{--        <i class="fa fa-eye"></i>--}}
{{--    </a>--}}
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
