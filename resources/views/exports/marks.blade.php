<table>
    <tr>
        <th style="background: #5bc0de; width: 100px; border: #000000 1px solid"><b>Mã học viên</b></th>
        <th  style="background: #5bc0de; width: 200px;"><b>Tên học viên</b></th>
        @if(count($markTypeDetail)==0)
            @foreach($scores as $score)
                <th  style="background: #5bc0de; width: 40px;"><b>Cột {{$score}}</b></th>
            @endforeach
        @else
            @foreach($scores as $score)
                <th  style="background: #5bc0de; width: 50px;"><b>{{$markTypeDetail[$score]->column_name}}</b></th>
            @endforeach
        @endif


    </tr>
    @foreach($students as $student)
        <tr>
            <td style="border: #000000 1px solid">{{$student->code}}</td>
            <td>{{$student->fullname}}</td>
            @foreach($scores as $score)
                <td >{{$marks[$student->student_id]['score'.$score]}}</td>
            @endforeach
        </tr>
    @endforeach
</table>
