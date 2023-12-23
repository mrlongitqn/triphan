<!-- Fullname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fullname', 'Họ tên:') !!}
    {!! Form::text('fullname', null, ['class' => 'form-control']) !!}
</div>

<!-- Dob Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dob', 'Ngày sinh:') !!}
    {!! Form::text('dob', null, ['class' => 'form-control','id'=>'dob']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#dob').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Phone Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_number', 'Điện thoại:') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Level Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level_id', 'Khối lớp:') !!}
    {!! Form::select('level_id', ['1' => 'Lớp 1',
'2'=>'Lớp 2',
'3'=>'Lớp 3', '4'=>'Lớp 4', '5'=>'Lớp 5', '6'=>'Lớp 6', '7'=>'Lớp 7', '8'=>'Lớp 8', '9'=>'Lớp 9', '10'=>'Lớp 10', '11'=>'Lớp 11', '12'=>'Lớp 12'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- School Field -->
<div class="form-group col-sm-6">
    {!! Form::label('school', 'Trường:') !!}
    {!! Form::text('school', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_name', 'Phụ huynh:') !!}
    {!! Form::text('parent_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Phone1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_phone1', 'Điện thoại 1:') !!}
    {!! Form::text('parent_phone1', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Phone2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_phone2', 'Điện thoại 2:') !!}
    {!! Form::text('parent_phone2', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Mail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_mail', 'Mail:') !!}
    {!! Form::text('parent_mail', null, ['class' => 'form-control']) !!}
</div>

<!-- Note Field -->
<div class="form-group col-sm-12">
    {!! Form::label('note', 'Ghi chú:') !!}
    {!! Form::textArea('note', null, ['class' => 'form-control']) !!}
</div>

{{--<!-- User Id Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('user_id', 'User Id:') !!}--}}
{{--    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Status Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('status', 'Status:') !!}--}}
{{--    {!! Form::select('status', ['' => ''], null, ['class' => 'form-control custom-select']) !!}--}}
{{--</div>--}}
