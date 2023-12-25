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
        $('#student_code').on('change', function (){
            let id = $(this).val();
            $.get('{{route('courseStudents.listCourse')}}/'+id, function (res){
                if(res.success){
                    $('#courses_list').empty();
                }
            })
        })

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
                                THÔNG TIN SINH VIÊN
                            </div>
                            <div class="card-body p-0">
                                <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Tìm kiếm sinh viên</label>
{{--                                    <div class="row">--}}
                                        <select name="student_code"  style="width: 100%"
                                                id="student_code"></select>
{{--                                    </div>--}}

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="card card-primary">
                            <div class="card-header">
                                Danh sách lớp học
                            </div>
                            <div class="card-body p-0">
                                @if(isset($course))
                                    <ul id="courses_list" class="list-group">

                                        @foreach($courses as $course)

                                        @endforeach
                                        <li data-id="{{$course->id}}" class="list-group-item
                                        {{$course->id == $course_id?"active":""}}
                                        ">{{$course->course}} ({{$course->fee}})
                                            - {{date('d-m-Y', strtotime($course->created_at))}}</li>
                                    </ul>
                                @else
                                    <p class="p2 text-center">Chưa có lớp</p>
                                @endif

                            </div>

                        </div>
                    </div>

                    <div class="col-sm-10">
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

