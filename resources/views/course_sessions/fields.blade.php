<input type="hidden" name="course_id" value="{{$course->id}}"/>
<!-- Day Of Week Field -->
<div class="form-group col-sm-6">
    {!! Form::label('day_of_week', 'Thứ') !!}
    {!! Form::select('day_of_week', [
    'Thứ 2'=>'Thứ 2',
    'Thứ 3'=>'Thứ 3',
    'Thứ 4'=>'Thứ 4',
    'Thứ 5'=>'Thứ 5',
    'Thứ 6'=> 'Thứ 6',
    'Thứ 7'=>'Thứ 7',
    'Chủ nhật'  => 'Chủ nhật',
], null, ['class' => 'form-control']) !!}
</div>
<!-- Session Field -->
<div class="form-group col-sm-6">
    {!! Form::label('session', 'Ca (lớp) học ') !!}
    {!! Form::text('session', null, ['class' => 'form-control']) !!}
</div>
