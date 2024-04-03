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
    {!! Form::label('courses', 'Lớp học: *** Lưu Ý: Sau khi đã tạo đợt nhập điểm, không thể thay đổi danh sách các lớp học của đợt, nếu bổ sung vui lòng tạo đợt mới ***') !!}
   <select @if(isset($sessionMark)) disabled  @endif id="courses" name="courses[]" multiple class="form-control">
        @if(isset($courses))
            @foreach($courses as $course)
                <option value="{{$course->id}}" selected>{{$course->course}}</option>
            @endforeach
        @endif
   </select>
</div>
{{--<div class="form-group col-sm-12">--}}
{{--    {!! Form::label('courses', 'Cột điểm:') !!}--}}
{{--   @for($i =1; $i<=10; $i++)--}}
{{--        <div class="icheck-primary d-inline mr-3">--}}
{{--            <input type="checkbox" name="scores[]" id="cb{{$i}}" value="{{$i}}"  @if(in_array($i, $scores)) checked @endif />--}}
{{--            <label for="cb{{$i}}">--}}
{{--               Cột {{$i}}--}}
{{--            </label>--}}
{{--        </div>--}}
{{--   @endfor--}}
{{--</div>--}}
<!-- Start Date Field -->




