@extends('layouts.app')
@push('third_party_stylesheets')
    <link rel="stylesheet" href="{{asset('vendor/jstree/themes/default/style.min.css')}}">
    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 37px;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 39px;
            user-select: none;
            -webkit-user-select: none;
        }
        #courses_list li{
            cursor: pointer;
        }
    </style>
@endpush
@push('third_party_scripts')
    <script src="{{asset('vendor/jstree/jstree.min.js')}}"></script>
    <script>
        $('#student_code').select2({
            ajax: {
                url: '{{route('student.search')}}',
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
        $('#student_code').on('change', function () {
            let id = $(this).val();
            $.get('{{route('courseStudents.listCourse')}}/' + id, function (res) {
                if (res.success) {
                    $('#courses_list').empty();
                    if(res.data.length > 0){
                        res.data.forEach(function (v) {
                            $('#courses_list').append('<li data-id="'+v.id+'" class="list-group-item">' +
                                v.course + ' ('+v.fee.toLocaleString()+') - '+ moment(v.created_at).format('d/M/Y'));
                        })
                    }else{
                        $('#courses_list').append('<p class="p2 text-center">Chưa có lớp</p>');
                    }
                }
            })
        })

        $(document).on('click', '#courses_list li', function (){
            $('#courses_list li').removeClass('active');
            $(this).addClass('active');
        });

    </script>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thu học phí</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                               <strong>THÔNG TIN SINH VIÊN</strong>
                            </div>
                            <div class="card-body p-0">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label>Tìm kiếm sinh viên</label>
                                        {{--                                    <div class="row">--}}
                                        <select name="student_code" style="width: 100%"
                                                id="student_code">
                                            @if(isset($student))
                                                <option value="{{$student->id}}" selected="selected">{{$student->code}} - {{$student->fullname}}</option>
                                            @endif

                                        </select>
                                        {{--                                    </div>--}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card card-warning">
                            <div class="card-header">
                                <strong>DANH SÁCH LỚP HỌC</strong>
                            </div>
                            <div class="card-body p-0">

                                <ul id="courses_list" class="list-group">
                                    @if(isset($courses))
                                        @foreach($courses as $course)
                                            <li data-id="{{$course->id}}" data-course="{{$course->course_id}}" class="list-group-item
                                        {{$course->course_id == $course_id?"active":""}}
                                        ">{{$course->course}} ({{number_format($course->fee,0, ',')}})
                                                - {{date('d/m/Y', strtotime($course->created_at))}}</li>
                                        @endforeach

                                    @else
                                        <p class="p2 text-center">Chưa có lớp</p>
                                    @endif
                                </ul>


                            </div>

                        </div>
                    </div>

                    <div class="col-sm-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DANH SÁCH HỌC VIÊN</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 250px;">

                                    </div>
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã học viên</th>
                                        <th>Họ tên</th>
                                        <th>Ngày sinh</th>
                                        <th>Điện thoại</th>
                                        <th>Ngày bắt đầu học</th>
                                        <th>Người thêm</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
@push('page_script')

@endpush

