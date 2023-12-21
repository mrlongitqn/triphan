<!-- Fullname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fullname', 'Fullname:') !!}
    {!! Form::text('fullname', null, ['class' => 'form-control']) !!}
</div>

<!-- Dob Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dob', 'Dob:') !!}
    {!! Form::text('dob', null, ['class' => 'form-control','id'=>'dob']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#dob').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Phone Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Level Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level_id', 'Level Id:') !!}
    {!! Form::select('level_id', ['' => ''], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- School Field -->
<div class="form-group col-sm-6">
    {!! Form::label('school', 'School:') !!}
    {!! Form::text('school', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_name', 'Parent Name:') !!}
    {!! Form::text('parent_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Phone1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_phone1', 'Parent Phone1:') !!}
    {!! Form::text('parent_phone1', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Phone2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_phone2', 'Parent Phone2:') !!}
    {!! Form::text('parent_phone2', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Mail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_mail', 'Parent Mail:') !!}
    {!! Form::text('parent_mail', null, ['class' => 'form-control']) !!}
</div>

<!-- Note Field -->
<div class="form-group col-sm-6">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::text('note', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['' => ''], null, ['class' => 'form-control custom-select']) !!}
</div>
