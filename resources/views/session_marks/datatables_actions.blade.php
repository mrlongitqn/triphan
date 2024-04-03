{!! Form::open(['route' => ['sessionMarks.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('sessionMarks.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Bạn chắc chắn xóa đợt nhập điểm? Khi đợt nhập điểm bị xóa thì các điểm đã nhập sẽ bị mất.')"
    ]) !!}
</div>
{!! Form::close() !!}
