<!-- Course Field -->
<div class="form-group col-sm-6">
    {!! Form::label('course', 'Tên khóa học:') !!}
    {!! Form::text('course', null, ['class' => 'form-control']) !!}
</div>

<!-- Fee Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fee', 'Học phí:') !!}
    {!! Form::number('fee', null, ['class' => 'form-control']) !!}
</div>

<!-- Level Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level_id', 'Khối lớp:') !!}
    {!! Form::select('level_id', $levels, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Subject Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subject_id', 'Môn học') !!}
    {!! Form::select('subject_id', $subjects, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Teacher Field -->
<div class="form-group col-sm-6">
    {!! Form::label('teacher', 'Giáo viên:') !!}
    {!! Form::text('teacher', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('schedules', 'Lịch học:') !!}
    {!! Form::text('schedules', null, ['class' => 'form-control', 'placeholder'=>'2,4,6']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('open', 'Giờ bắt đầu:') !!}
    {!! Form::text('open', null, ['class' => 'form-control']) !!}
</div><div class="form-group col-sm-6">
    {!! Form::label('close', 'Giờ kết thúc:') !!}
    {!! Form::text('close', null, ['class' => 'form-control']) !!}
</div>


<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Ngày bắt đầu:') !!}
    {!! Form::text('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
</div>
<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'Ngày kết thúc:') !!}
    {!! Form::text('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
</div>
@push('page_scripts')
    <script type="text/javascript">
        $('#start_date').datetimepicker({
            format: 'YYYY/MM/DD',
            useCurrent: true,
            sideBySide: true
        });
        $('#open').datetimepicker({
            format: 'HH:mm',
        });
        $('#close').datetimepicker({
            format: 'HH:mm'
        })
        $('#end_date').datetimepicker({
            format: 'YYYY/MM/DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

