{!! Form::open(['route' => ['levels.destroy', $id], 'method' => 'delete', 'class'=>'text-center']) !!}
<div class='btn-group'>
{{--    <a href="{{ route('levels.show', $id) }}" class='btn btn-default btn-xs'>--}}
{{--        <i class="fa fa-eye"></i>--}}
{{--    </a>--}}
    <a href="{{ route('levels.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Bạn có chắc chắn xóa?')"
    ]) !!}
</div>
{!! Form::close() !!}
