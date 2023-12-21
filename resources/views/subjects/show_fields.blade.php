<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $subject->id }}</p>
</div>

<!-- Subject Field -->
<div class="col-sm-12">
    {!! Form::label('subject', 'Subject:') !!}
    <p>{{ $subject->subject }}</p>
</div>

<!-- Desc Field -->
<div class="col-sm-12">
    {!! Form::label('desc', 'Desc:') !!}
    <p>{{ $subject->desc }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $subject->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $subject->updated_at }}</p>
</div>

