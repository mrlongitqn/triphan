<!-- Mark Type Id Field -->
    {!! Form::hidden('mark_type_id', $markType->id, ['class' => 'form-control']) !!}

<!-- Column Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('column_number', 'Cột thứ:') !!}
    {!! Form::text('column_number', $markTypeDetail->column_number, ['class' => 'form-control', 'readonly'=>'readonly']) !!}
</div>

<!-- Column Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('column_name', 'Tên cột:') !!}
    {!! Form::text('column_name', null, ['class' => 'form-control']) !!}
</div>
