{!! Form::open(['route' => ['markTypes.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>

    <a href="{{ route('markTypes.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Bạn chắc chắn xóa loại điểm?')"
    ]) !!}
</div>
{!! Form::close() !!}
