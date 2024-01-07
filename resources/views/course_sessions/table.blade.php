<div class="table-responsive">
    <table class="table" id="courseSessions-table">
        <thead>
        <tr>
            <th>Thứ</th>
            <th>Tên ca</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @if($courseSessions->count()==0)
            <tr><td colspan="3" class="text-center">
                    Chưa có ca học nào
                </td> </tr>
        @endif
        @foreach($courseSessions as $courseSession)
            <tr>
                <td>{{ $courseSession->day_of_week }}</td>
                <td>{{ $courseSession->session }}</td>
                <td width="190">
                    {!! Form::open(['route' => ['courseSessions.destroy', $courseSession->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
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
