<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $courseSession->id }}</p>
</div>

<!-- Course Id Field -->
<div class="col-sm-12">
    {!! Form::label('course_id', 'Course Id:') !!}
    <p>{{ $courseSession->course_id }}</p>
</div>

<!-- Day Of Week Field -->
<div class="col-sm-12">
    {!! Form::label('day_of_week', 'Day Of Week:') !!}
    <p>{{ $courseSession->day_of_week }}</p>
</div>

<!-- Session Field -->
<div class="col-sm-12">
    {!! Form::label('session', 'Session:') !!}
    <p>{{ $courseSession->session }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $courseSession->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $courseSession->updated_at }}</p>
</div>

