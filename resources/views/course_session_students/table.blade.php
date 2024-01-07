<div class="table-responsive">
    <table class="table" id="courseSessionStudents-table">
        <thead>
        <tr>
            <th>Course Id</th>
        <th>Session Id</th>
        <th>Student Id</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($courseSessionStudents as $courseSessionStudent)
            <tr>
                <td>{{ $courseSessionStudent->course_id }}</td>
            <td>{{ $courseSessionStudent->session_id }}</td>
            <td>{{ $courseSessionStudent->student_id }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['courseSessionStudents.destroy', $courseSessionStudent->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('courseSessionStudents.show', [$courseSessionStudent->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('courseSessionStudents.edit', [$courseSessionStudent->id]) }}"
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
