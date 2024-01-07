<div class="table-responsive">
    <table class="table" id="courseSessions-table">
        <thead>
        <tr>
            <th>Course Id</th>
        <th>Day Of Week</th>
        <th>Session</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($courseSessions as $courseSession)
            <tr>
                <td>{{ $courseSession->course_id }}</td>
            <td>{{ $courseSession->day_of_week }}</td>
            <td>{{ $courseSession->session }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['courseSessions.destroy', $courseSession->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('courseSessions.show', [$courseSession->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('courseSessions.edit', [$courseSession->id]) }}"
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
