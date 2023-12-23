<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $fee->id }}</p>
</div>

<!-- Course Student Id Field -->
<div class="col-sm-12">
    {!! Form::label('course_student_id', 'Course Student Id:') !!}
    <p>{{ $fee->course_student_id }}</p>
</div>

<!-- Course Id Field -->
<div class="col-sm-12">
    {!! Form::label('course_id', 'Course Id:') !!}
    <p>{{ $fee->course_id }}</p>
</div>

<!-- Student Id Field -->
<div class="col-sm-12">
    {!! Form::label('student_id', 'Student Id:') !!}
    <p>{{ $fee->student_id }}</p>
</div>

<!-- Fee Field -->
<div class="col-sm-12">
    {!! Form::label('fee', 'Fee:') !!}
    <p>{{ $fee->fee }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $fee->amount }}</p>
</div>

<!-- Remain Field -->
<div class="col-sm-12">
    {!! Form::label('remain', 'Remain:') !!}
    <p>{{ $fee->remain }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $fee->status }}</p>
</div>

<!-- Refund Field -->
<div class="col-sm-12">
    {!! Form::label('refund', 'Refund:') !!}
    <p>{{ $fee->refund }}</p>
</div>

