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
        #tableStudent_Header_Freeze,#tableStudent_Content_Freeze{
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

    </style>
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý điểm</h1>
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
                                                                                    href="{{route('marks.index', $course->id)}}">{{$course->course}}</a>
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
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table id="tableStudent" class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>Mã học viên</th>
                                        <th>Họ tên</th>
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($courseStudent as $student)
                                        <tr>
                                            <td>{{$student->code}}</td>
                                            <td>{{$student->fullname}} {!! $student->fee_status==1?'':'<span class="badge bg-warning">Nợ học phí</span>' !!}</td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score1" value="{{$marks[$student->id]->score1}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score2" value="{{$marks[$student->id]->score2}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score3" value="{{$marks[$student->id]->score3}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score4" value="{{$marks[$student->id]->score4}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score5" value="{{$marks[$student->id]->score5}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score6" value="{{$marks[$student->id]->score6}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score7" value="{{$marks[$student->id]->score7}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score8" value="{{$marks[$student->id]->score8}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score9" value="{{$marks[$student->id]->score9}}" /></td>
                                           <td><input type="number" min="0" max="10" step="0.1" width="24" height="24" name="{{$student->id}}_score10" value="{{$marks[$student->id]->score10}}" /></td>

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
                        elementID : "tableStudent", // Target element id
                        width : '100%', // Integer or String(Percentage)
                        //height : 800, // Integer or String(Percentage)
                        freezeColumn : true, // Boolean
                        freezeFooter : false, // Boolean
                        freezeColumnCssClass : "", // String
                        freezeFooterCssClass : "", // String
                        freezeHeaderRowCount : 1, // Integer
                        freezeColumnCount : 2, // Integer
                       // onscroll: function (scrollTop, scrollLeft) // onscroll event callback
                    });
                    gridViewScroll.enhance();
                }

            </script>
    @endpush

