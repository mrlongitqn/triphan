<table>
    <tr>
        <td style="font-weight: bold; color: #0a6aa1; font-size: 15pt">DANH SÁCH LỚP {{$course->course}} ({{number_format($course->fee)}}/tháng); KHAI GIẢNG TỪ: {{$course->start_date->format('d-m-Y')}}</td>

    </tr>
    <tr>
        <th style="background: #5bc0de; width: 80px; border: 1px solid #CCC"><b>Mã học viên</b></th>
        <th style="background: #5bc0de; width: 200px; border: 1px solid #CCC"><b>Tên học viên</b></th>
        <th style="background: #5bc0de; width: 100px;  border: 1px solid #CCC"><b>Ngày sinh</b></th>
        <th style="background: #5bc0de; width: 100px;  border: 1px solid #CCC"><b>Điện thoại</b></th>
        @foreach($monthYear as $k => $month)
            <th style="background: #5bc0de; width: 100px; border: 1px solid #CCC"><b>Tháng {{$month->month}}/{{$month->year}}</b></th>
            <th style="background: #5bc0de; width: 150px;border: 1px solid #CCC"><b>Ghi chú</b></th>
        @endforeach

    </tr>
    @foreach($students as $student)
        <tr>
            <td style="border: 1px solid #CCC">{{$student->code}}</td>
            <td style="border: 1px solid #CCC">{{$student->fullname}}</td>
            <td style="border: 1px solid #CCC">{{$student->dob}}</td>
            <td style="border: 1px solid #CCC">{{$student->phone_number}}/{{$student->parent_phone1}}</td>
            @foreach($monthYear as $k => $month)
                @php
                    $fee = $fees->filter(function ($f) use ($student, $month) {
                        return $f->course_student_id == $student->id && $f->month == $month->month && $f->year == $month->year;
                    });
                @endphp
                <td style="border: 1px solid #CCC">
                    {{number_format($fee->sum('amount'))}}
                </td>
                <td style="border: 1px solid #CCC">
                    @foreach($fee as $k => $f)
                        {{$f->note?$f->note.';':''}}
                    @endforeach
                </td>
            @endforeach
        </tr>
    @endforeach
    <tr>
        <td style="border: 1px solid #CCC"></td>
        <td style="border: 1px solid #CCC"></td>
        <td style="border: 1px solid #CCC"></td>

        <td style="border: 1px solid #CCC">Tổng cộng</td>
        @foreach($monthYear as $k => $month)
            @php
                $fee = $fees->filter(function ($f) use ($student, $month) {
                    return $f->month == $month->month && $f->year == $month->year;
                })->sum('amount');

            @endphp
         <td style="border: 1px solid #CCC"> <b>{{number_format($fee)}}</b></td>
            <td style="border: 1px solid #CCC"></td>
        @endforeach
    </tr>
</table>
