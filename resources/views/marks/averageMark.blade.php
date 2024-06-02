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

        #tableStudent_Header_Freeze, #tableStudent_Content_Freeze {
            background: #ffffff;
        }

        #tableStudent_Content_Fixed::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        #tableStudent_Content_Fixed::-webkit-scrollbar:vertical {
            width: 11px;
        }

        #tableStudent_Content_Fixed::-webkit-scrollbar:horizontal {
            height: 11px;
        }

        #tableStudent_Content_Fixed::-webkit-scrollbar-thumb {
            border-radius: 8px;
            border: 2px solid white; /* should match background, can't be transparent */
            background-color: rgba(0, 0, 0, .5);
        }

        #btnImport {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Điểm trung bình</h1>
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
                    <div class="col-sm-2">
                        <div class="card card-primary">
                            <div class="card-header">
                                Quản lý điểm
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
                                                                                    href="{{route('marks.avg', $course->id)}}">{{$course->course}}</a>
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
                                <div class="card-title">
                                    Điểm chuẩn: {{number_format($selected_course->benchmark,1)}}
                                </div>
                                <div class="card-tools">


                                    <div class="btn-group" style="margin-left: 20px">

                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modal-sm">
                                            <i class="fas fa-file-export"></i>
                                        </button>
                                        <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown" data-offset="-52" aria-expanded="false">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a target="_blank"
                                               href="{{route('courseStudents.printList')}}/{{$selected_course->id}}/on"
                                               class="dropdown-item">In danh sách lớp</a>
                                            <a target="_blank"
                                               href="{{route('fees.listFeeDebtByCourse')}}/{{$selected_course->id}}"
                                               class="dropdown-item">Danh sách nợ học phí</a>

                                            <a target="_blank"
                                               href="{{route('courseStudents.printList')}}/{{$selected_course->id}}"
                                               class="dropdown-item">In danh sách tổng</a>
                                        </div>

                                    </div>
                                    <div class="float-right">

                                    </div>
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <form id="frmUp" action="{{route('courseStudents.upLevel')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal fade" id="modal-level" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Nâng lớp</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <h6>Vui lòng chọn lớp cần nâng</h6>
                                                        <div class="row">
                                                            <select name="course_up" class="course-level" style="width: 100%">
                                                                @foreach($courses as $course)

                                                                    <option value="{{$course->id}}">{{$course->course}} - {{$course->start_date->format('d/m/Y')}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Đóng</button>
                                                    <button type="button" id="btnUp" class="btn btn-primary">Nâng lớp</button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <table id="modalCourses" class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Mã học viên</th>
                                            <th>Họ tên</th>
                                            @if(count($markTypeDetail)==0)
                                                <th>Cột 1</th>
                                                <th>Cột 2</th>
                                                <th>Cột 3</th>
                                                <th>Cột 4</th>
                                                <th>Cột 5</th>
                                                <th>Cột 6</th>
                                                <th>Cột 7</th>
                                                <th>Cột 8</th>
                                                <th>Cột 9</th>
                                                <th>Cột 10</th>
                                            @else
                                                @foreach($markTypeDetail as $key=>$val)
                                                    <th>
                                                        {{$val->column_name}}
                                                    </th>
                                                @endforeach
                                            @endif
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($courseStudent as $student)
                                            <tr>
                                                <td>{{$student->code}}</td>
                                                <td>{{$student->fullname}} {!! $student->fee_status==1?'':'<span class="badge bg-warning">Nợ học phí</span>' !!}</td>
                                                @if(isset($marks[$student->student_id]))

                                                    @if(count($markTypeDetail)==0)
                                                        <td><input readonly type="number"
                                                                   min="0"
                                                                   max="10" step="0.1" size="5"
                                                                   height="24"
                                                                   value="{{number_format($marks[$student->student_id]->avg_score1,1)}}"/>
                                                        </td>
                                                        <td><input readonly type="number"
                                                                   min="0"
                                                                   max="10" step="0.1" size="5"
                                                                   height="24"
                                                                   value="{{number_format($marks[$student->student_id]->avg_score2,1)}}"/>
                                                        </td>
                                                        <td><input readonly type="number"
                                                                   min="0"
                                                                   max="10" step="0.1" size="5"
                                                                   height="24"
                                                                   value="{{number_format($marks[$student->student_id]->avg_score3,1)}}"/>
                                                        </td>
                                                        <td><input readonly
                                                                   type="number"
                                                                   min="0" max="10" step="0.1" size="5"
                                                                   height="24"

                                                                   value="{{number_format($marks[$student->student_id]->avg_score4,1)}}"/>
                                                        </td>
                                                        <td><input readonly type="number"
                                                                   min="0"
                                                                   max="10" step="0.1" size="5"
                                                                   height="24"

                                                                   value="{{number_format($marks[$student->student_id]->avg_score5,1)}}"/>
                                                        </td>
                                                        <td><input readonly type="number"
                                                                   min="0"
                                                                   max="10" step="0.1" size="5"
                                                                   height="24"

                                                                   value="{{number_format($marks[$student->student_id]->avg_score6,1)}}"/>
                                                        </td>
                                                        <td><input readonly type="number"
                                                                   min="0"
                                                                   max="10" step="0.1" size="5"
                                                                   height="24"

                                                                   value="{{number_format($marks[$student->student_id]->avg_score7,1)}}"/>
                                                        </td>
                                                        <td><input readonly type="number"
                                                                   min="0"
                                                                   max="10" step="0.1" size="5"
                                                                   height="24"

                                                                   value="{{number_format($marks[$student->student_id]->avg_score8,1)}}"/>
                                                        </td>
                                                        <td><input readonly type="number"
                                                                   min="0"
                                                                   max="10" step="0.1" size="5"
                                                                   height="24"

                                                                   value="{{number_format($marks[$student->student_id]->avg_score9,1)}}"/>
                                                        </td>
                                                        <td><input
                                                                readonly type="number"
                                                                min="0" max="10" step="0.1" size="5"
                                                                height="24"

                                                                value="{{number_format($marks[$student->student_id]->avg_score10,1)}}"/>
                                                        </td>
                                                    @else
                                                        @foreach($markTypeDetail as $key=>$val)
                                                            @php
                                                                $scoreField = 'avg_score'.$val->column_number;
                                                            @endphp
                                                            <td>
                                                                <input
                                                                    readonly type="number"
                                                                    class="{{$selected_course->benchmark<=$marks[$student->student_id]->$scoreField?'more-than':'less-than'}}"
                                                                    min="0" max="10" step="0.1" size="5"
                                                                    height="24"
                                                                    value="{{number_format($marks[$student->student_id]->$scoreField,1)}}"/>
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                    <td>
                                                        <input type="checkbox" name="student_ids[]"
                                                               value="{{$student->id}}"/>
                                                    </td>
                                                @else
                                                    @if(count($markTypeDetail)==0)
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                        <td><input readonly size="5" height="24"/></td>
                                                    @else
                                                        @foreach($markTypeDetail as $key=>$val)
                                                            <td>
                                                                <input readonly type="number" size="5" height="24"/>
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                    <td><input type="checkbox" name="student_ids[]"
                                                               value="{{$student->id}}"/></td>
                                                @endif

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                        <div>

                                                <p style="width: 50%; float: left">
                                                    Tổng số {{$courseStudent->count()}} học viên,
                                                    có {{$courseStudent->where('status','=',1)->count()}} học viên nghỉ học
                                                </p>

                                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                                    data-target="#modal-level">
                                                <i class="fas fa-file-export"></i> Nâng lớp
                                            </button>
                                        </div>



                                </form>
                            </div>
                            <div class="card-footer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-sm" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Xuất Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6>Vui lòng chọn côt điểm cần xuất</h6>
                        <form id="formExport" action="{{route('marks.exportMarks', $selected_course->id)}}"
                              method="get">
                            <div class="row">
                                @if(count($markTypeDetail)==0)
                                    <div class="col-6">
                                        <input id="cb1" type="checkbox" name="cols[]" value="1"> <label for="cb1">Cột
                                            1</label><br/>
                                        <input id="cb2" type="checkbox" name="cols[]" value="2"> <label for="cb2">Cột
                                            2</label><br/>
                                        <input id="cb3" type="checkbox" name="cols[]" value="3"> <label for="cb3">Cột
                                            3</label><br/>
                                        <input id="cb4" type="checkbox" name="cols[]" value="4"> <label for="cb4">Cột
                                            4</label><br/>
                                        <input id="cb5" type="checkbox" name="cols[]" value="5"> <label for="cb5">Cột
                                            5</label><br/>
                                    </div>
                                    <div class="col-6">
                                        <input id="cb6" type="checkbox" name="cols[]" value="6"> <label for="cb6">Cột
                                            6</label><br/>
                                        <input id="cb7" type="checkbox" name="cols[]" value="7"> <label for="cb7">Cột
                                            7</label><br/>
                                        <input id="cb8" type="checkbox" name="cols[]" value="8"> <label for="cb8">Cột
                                            8</label><br/>
                                        <input id="cb9" type="checkbox" name="cols[]" value="9"> <label for="cb9">Cột
                                            9</label><br/>
                                        <input id="cb10" type="checkbox" name="cols[]" value="10"> <label for="cb10">Cột
                                            10</label><br/>
                                    </div>
                                @else
                                    <div class="col-12">
                                        @foreach($markTypeDetail as $key=>$val)
                                            @php
                                                $scoreField = 'score'.$val->column_number;
                                            @endphp
                                            <input id="cb{{$val->column_number}}" type="checkbox" checked name="cols[]"
                                                   value="{{$val->column_number}}"> <label
                                                for="cb{{$val->column_number}}">({{$val->column_number}}
                                                ) {{$val->column_name}}</label><br/>
                                        @endforeach
                                    </div>
                                @endif


                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Đóng</button>
                        <button type="button" id="btnExport" class="btn btn-primary">Xuất EXCEL</button>
                    </div>
                </div>

            </div>

        </div>
        @endsection
        @push('third_party_scripts')
            <script src="{{asset('vendor/jstree/jstree.min.js')}}"></script>
            <script src="{{asset('vendor/gridviewscroll.js')}}"></script>
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
                window.onload = function () {
                    var gridViewScroll = new GridViewScroll({
                        elementID: "tableStudent", // Target element id
                        width: '100%', // Integer or String(Percentage)
                        //height : 800, // Integer or String(Percentage)
                        freezeColumn: true, // Boolean
                        freezeFooter: false, // Boolean
                        freezeColumnCssClass: "", // String
                        freezeFooterCssClass: "", // String
                        freezeHeaderRowCount: 1, // Integer
                        freezeColumnCount: 2, // Integer
                        // onscroll: function (scrollTop, scrollLeft) // onscroll event callback
                    });
                    gridViewScroll.enhance();
                };
                $('#btnExport').on('click', function () {
                    if ($('input[name="cols[]"]:checked').length === 0) {
                        alert('Vui lòng chọn cột điểm cần xuất');
                        return;
                    }
                    $('#modal-sm').modal('hide');
                    $('#formExport').submit();
                });
                $('#btnUp').on('click', function () {

                    $('#modal-sm').modal('hide');
                    $('#frmUp').submit();
                });

                $('.course-level').select2();
            </script>
    @endpush

