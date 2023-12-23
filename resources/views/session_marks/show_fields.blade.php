<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $sessionMark->id }}</p>
</div>

<!-- Session Field -->
<div class="col-sm-12">
    {!! Form::label('session', 'Session:') !!}
    <p>{{ $sessionMark->session }}</p>
</div>

<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{{ $sessionMark->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{{ $sessionMark->end_date }}</p>
</div>

<!-- Desc Field -->
<div class="col-sm-12">
    {!! Form::label('desc', 'Desc:') !!}
    <p>{{ $sessionMark->desc }}</p>
</div>

<!-- Course Ids Field -->
<div class="col-sm-12">
    {!! Form::label('course_ids', 'Course Ids:') !!}
    <p>{{ $sessionMark->course_ids }}</p>
</div>

