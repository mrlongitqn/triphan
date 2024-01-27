<div class="table-responsive">
    <table class="table" id="sessionMarkDetails-table">
        <thead>
        <tr>
            <th>Session Mark Id</th>
        <th>Course Id</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sessionMarkDetails as $sessionMarkDetail)
            <tr>
                <td>{{ $sessionMarkDetail->session_mark_id }}</td>
            <td>{{ $sessionMarkDetail->course_id }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['sessionMarkDetails.destroy', $sessionMarkDetail->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('sessionMarkDetails.show', [$sessionMarkDetail->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('sessionMarkDetails.edit', [$sessionMarkDetail->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
