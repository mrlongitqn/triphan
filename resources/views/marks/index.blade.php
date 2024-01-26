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

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý học</h1>
                </div>
                {{--                <div class="col-sm-6">--}}
                {{--                    <a class="btn btn-primary float-right"--}}
                {{--                       href="">--}}
                {{--                        Add New--}}
                {{--                    </a>--}}
                {{--                </div>--}}
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-2">

                <div class="row">
                    <div class="col-sm-2">
                        <div class="card card-primary">
                            <div class="card-header">
                                Danh sách lớp học
                            </div>
                            <div class="card-body p-0">
                                <div id="courses">
                                    <ul>
                                        @foreach($levels as $level)
                                            @php
                                                $by_level = $courses->where('level_id', '=', $level->id);
                                            @endphp
                                            @if($by_level->count()>0)
                                                <li> {{$level->level}}
                                                    <ul>
                                                        @foreach($subjects as $subject)
                                                            @php
                                                                $by_course = $courses->where('level_id', '=', $level->id)->where('subject_id','=', $subject->id);
                                                            @endphp
                                                            @if($by_course->count()>0)
                                                                <li>{{$subject->subject}}
                                                                    <ul>
                                                                        @foreach($by_course as $course)
                                                                            <li><a
                                                                                    @if($course->id == $selected_course->id)
                                                                                        class="jstree-clicked"
                                                                                    @endif
                                                                                    href="{{route('courseStudents.index', $course->id)}}">{{$course->course}}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @endif

                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DANH SÁCH HỌC VIÊN</h3>
                                <div class="card-tools">
                                    <div class="btn-group" style="margin-left: 20px">
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52" aria-expanded="false">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a target="_blank" href="{{route('courseStudents.printList')}}/{{$selected_course->id}}/on" class="dropdown-item">In danh sách lớp</a>
                                            <a target="_blank" href="{{route('fees.listFeeDebtByCourse')}}/{{$selected_course->id}}" class="dropdown-item">Danh sách nợ học phí</a>

                                            <a target="_blank" href="{{route('courseStudents.printList')}}/{{$selected_course->id}}" class="dropdown-item">In danh sách tổng</a>
                                        </div>
                                    </div>
                                    @if($courseSessions->count()>0)
                                        <div class="btn-group" style="margin-left: 20px">
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52" aria-expanded="false">
                                                <i class="far fa-calendar-alt"></i> In theo ca
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">

                                                @foreach($courseSessions as $ses)
                                                    <a  target="_blank" href="{{route('courseStudents.printListBySession')}}/{{$selected_course->id}}/{{$ses->id}}" class="dropdown-item">{{$ses->day_of_week}} - {{$ses->session}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="input-group input-group-sm" style="width: 250px; float: right; margin-left: 40px">

                                        {!! Form::open(['route' => 'courseStudents.store' , 'id'=>'formSave']) !!}
                                        <input type="hidden" name="course_id" value="{{$selected_course->id}}">
                                        <select name="student_id" style="width: 200px"
                                                class="js-data-example-ajax"></select>
                                        @if($courseSessions->count()>0)
                                            <div class="modal fade show" id="modal-session" aria-modal="true"
                                                 role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Vui lòng chọn ca học</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @foreach($courseSessions as $ses)
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input class="custom-control-input"
                                                                               type="checkbox" name="courseSession[]"
                                                                               id="customCheckbox{{$ses->id}}"
                                                                               value="{{$ses->id}}">
                                                                        <label for="customCheckbox{{$ses->id}}"
                                                                               class="custom-control-label">{{$ses->day_of_week}}
                                                                            - {{$ses->session}}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Đóng
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Thêm vào lớp
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif

                                        <button type="button" class="btn btn-default pull-right" id="btnSave">
                                            <i class="fas fa-plus"></i>
                                        </button>


                                        {!! Form::close() !!}
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
                                    @foreach($courseStudent as $student)
                                        <tr @if($student->status == 1)
                                                class="bg-secondary"
                                            @endif
                                        >
                                            <td><input type="checkbox"></td>
                                            <td>{{$student->code}}</td>
                                            <td>{{$student->fullname}} {!! $student->fee_status==1?'':'<span class="badge bg-warning">Nợ học phí</span>' !!}</td>
                                            <td>{{date('d-m-Y', strtotime($student->dob))}}</td>
                                            <td>{{$student->phone}}</td>
                                            <td>{{date('d-m-Y', strtotime($student->created_at))}}</td>
                                            <td>{{$student->name}}</td>
                                            <td>
                                                <div class='btn-group'>
                                                    @if($student->status == 0)
                                                        <a href="{{ route('fees.collect', $student->student_id) }}"
                                                           title="Thu học phí" class='btn btn-default btn-xs'>
                                                            <i class="fas fa-money-check"></i>
                                                        </a>
                                                        @if($courseSessions->count()>0)
                                                            <a href="javascript:"
                                                               title="Xem ca học"
                                                               data-id="{{$student->id}}"
                                                               data-sessions="{{$student->sessions}}"
                                                               class='btn btn-default btn-xs btnSession'>
                                                                <i class="fas fa-calendar-alt"></i>
                                                            </a>
                                                        @endif

                                                        <a data-id="{{$student->id}}" href="javascript:" title="Nghỉ học"
                                                           class='btn btn-default btn-xs changeStatus'>
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    @else
                                                        <a data-id="{{$student->id}}"  title="Mở lại" href="javascript:"
                                                           class='btn btn-default btn-xs changeStatus'>
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>



                                </table>
                                <p>
                                    Tổng số {{$courseStudent->count()}} học viên,
                                    có {{$courseStudent->where('status','=',1)->count()}} học viên nghỉ học
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($courseSessions->count()>0)
            <div class="modal fade show" id="modal-update-session" aria-modal="true"
                 role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Danh sách ca học</h4>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('courseStudents.updateSession')}}" method="post">

                            <input name="_token" type="hidden" value="{{csrf_token()}}">
                            <input type="hidden" name="studentCourseId" id="studentCourseId" value="0">
                            <div class="modal-body">
                                @foreach($courseSessions as $ses)
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input update-check"
                                                   type="checkbox" name="courseSession[]"
                                                   id="update_session_{{$ses->id}}"
                                                   value="{{$ses->id}}">
                                            <label for="update_session_{{$ses->id}}"
                                                   class="custom-control-label">{{$ses->day_of_week}}
                                                - {{$ses->session}}</label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal">Đóng
                                </button>
                                <button type="submit" class="btn btn-primary">Cập nhật ca
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @endif
        @endsection
        @push('third_party_scripts')
            <script src="{{asset('vendor/jstree/jstree.min.js')}}"></script>
            <script>
                $.jstree.defaults.core.themes.variant = "large";
                $(function () {

                    $('#courses').jstree();
                    $("#courses").on("select_node.jstree", function (e, data) {
                        // Kiểm tra xem node có phải là node lá không
                        if (data.node.children.length === 0) {
                            // Lấy href của node được chọn
                            var nodeHref = data.node.a_attr.href;

                            // Chuyển hướng đến href
                            window.location.href = nodeHref;
                        }
                    });
                });

                $('.js-data-example-ajax').select2({
                    ajax: {
                        url: '{{route('student.search')}}',
                        dataType: 'json'
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    }
                });
                $(document).on('click', '.changeStatus', function () {
                    if (confirm('Bạn chắn chắn đổi trạng thái đối với học viên này')) {
                        $.get('{{ route('courseStudents.updateStatus') }}/' + $(this).data('id'), function (data) {
                            if (data.success) {
                                // Reload trang ngay lập tức
                                location.reload();
                            }
                        });
                    }

                });
                var hasSession = {{$courseSessions->count()}};
                $('#btnSave').on('click', function () {
                    if (hasSession > 0)
                        $('#modal-session').modal('show');
                    else {
                        $('#formSave').submit();
                    }
                });
                $('.btnSession').on('click', function () {
                    let studentCourseId = $(this).data('id');
                    $('#studentCourseId').val(studentCourseId);
                    let sessions = $(this).data('sessions')+"";
                    const array = sessions.split(',');
                    $(".update-check").prop("checked", false);
                    array.forEach(x=>{
                        $('#update_session_'+x).prop('checked', 'checked');
                    })

                    $('#modal-update-session').modal('show');
                });

            </script>
    @endpush

