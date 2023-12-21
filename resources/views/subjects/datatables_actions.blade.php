{!! Form::open(['route' => ['subjects.destroy', $id], 'method' => 'delete',  'class'=>'text-center']) !!}
<div class='btn-group'>
{{--    <a href="{{ route('subjects.show', $id) }}" class='btn btn-default btn-xs'>--}}
{{--        <i class="fa fa-eye"></i>--}}
{{--    </a>--}}
    <a href="{{ route('subjects.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
