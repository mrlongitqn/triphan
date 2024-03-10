<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $markTypeDetail->id }}</p>
</div>

<!-- Mark Type Id Field -->
<div class="col-sm-12">
    {!! Form::label('mark_type_id', 'Mark Type Id:') !!}
    <p>{{ $markTypeDetail->mark_type_id }}</p>
</div>

<!-- Column Number Field -->
<div class="col-sm-12">
    {!! Form::label('column_number', 'Column Number:') !!}
    <p>{{ $markTypeDetail->column_number }}</p>
</div>

<!-- Column Name Field -->
<div class="col-sm-12">
    {!! Form::label('column_name', 'Column Name:') !!}
    <p>{{ $markTypeDetail->column_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $markTypeDetail->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $markTypeDetail->updated_at }}</p>
</div>

