<!-- Session Field -->
<div class="form-group col-sm-6">
    {!! Form::label('session', 'Session:') !!}
    {!! Form::text('session', null, ['class' => 'form-control']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::text('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::text('end_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Desc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('desc', 'Desc:') !!}
    {!! Form::text('desc', null, ['class' => 'form-control']) !!}
</div>

<!-- Course Ids Field -->
<div class="form-group col-sm-6">
    {!! Form::label('course_ids', 'Course Ids:') !!}
    {!! Form::text('course_ids', null, ['class' => 'form-control']) !!}
</div>