<!-- Session Field -->
<div class="form-group col-sm-6">
    {!! Form::label('session', 'Tên đợt:') !!}
    {!! Form::text('session', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    <label for="datetime">Thời gian</label>
    <div class="input-group">
        <div class="input-group-prepend" id="datetimePick">
                                        <span class="input-group-text">
                                         <i class="fa fa-calendar"></i>
                                        </span>
        </div>
        <input type="text" class="form-control float-right" name="datetime" id="datetime"
               value="{{$datetime}}">
    </div>
</div>

<!-- Desc Field -->
<div class="form-group col-sm-12">
    {!! Form::label('desc', 'Mô tả:') !!}
    {!! Form::text('desc', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('courses', 'Lớp học:') !!}
   <select id="courses" name="courses[]" multiple class="form-control">
        @if(isset($courses))
            @foreach($courses as $course)
                <option value="{{$course->id}}" selected>{{$course->course}}</option>
            @endforeach
        @endif
   </select>
</div>
<!-- Start Date Field -->




