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

                                        <form id="frmImport" action="{{route('marks.import')}}" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="_token"
                                                   value="6ypcOOXl70PeRqVQtE8bQySLVBxdtxz3CfybwzEN">
                                            <input type="hidden" name="course_id" value="{{$selected_course->id}}"/>
                                            <div class="input-group m-0 pl-5">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input custom-file-sm" name="fileImport"
                                                           id="fileImport" accept=".xls, .xlsx">
                                                    <label class="custom-file-label " for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span id="btnImport" class="input-group-text">Import</span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="float-right">

                                    </div>
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <form id="frmMark" method="post" action="{{route('marks.store')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="course_id" value="{{$selected_course->id}}"/>
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
                                                <td><input {{!in_array(1, $scores)?'disabled':''}} type="number" min="0"
                                                           max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score1"
                                                           value="{{$marks[$student->id]->score1}}"/></td>
                                                <td><input {{!in_array(2, $scores)?'disabled':''}} type="number" min="0"
                                                           max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score2"
                                                           value="{{$marks[$student->id]->score2}}"/></td>
                                                <td><input {{!in_array(3, $scores)?'disabled':''}} type="number" min="0"
                                                           max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score3"
                                                           value="{{$marks[$student->id]->score3}}"/></td>
                                                <td><input {{!in_array(4 , $scores)?'disabled':''}} type="number"
                                                           min="0" max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score4"
                                                           value="{{$marks[$student->id]->score4}}"/></td>
                                                <td><input {{!in_array(5, $scores)?'disabled':''}} type="number" min="0"
                                                           max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score5"
                                                           value="{{$marks[$student->id]->score5}}"/></td>
                                                <td><input {{!in_array(6, $scores)?'disabled':''}} type="number" min="0"
                                                           max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score6"
                                                           value="{{$marks[$student->id]->score6}}"/></td>
                                                <td><input {{!in_array(7, $scores)?'disabled':''}} type="number" min="0"
                                                           max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score7"
                                                           value="{{$marks[$student->id]->score7}}"/></td>
                                                <td><input {{!in_array(8, $scores)?'disabled':''}} type="number" min="0"
                                                           max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score8"
                                                           value="{{$marks[$student->id]->score8}}"/></td>
                                                <td><input {{!in_array(9, $scores)?'disabled':''}} type="number" min="0"
                                                           max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score9"
                                                           value="{{$marks[$student->id]->score9}}"/></td>
                                                <td><input {{!in_array(10, $scores)?'disabled':''}} type="number"
                                                           min="0" max="10" step="0.1" width="24"
                                                           height="24"
                                                           name="{{$student->id}}_score10"
                                                           value="{{$marks[$student->id]->score10}}"/></td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </form>
                                <p>
                                    Tổng số {{$courseStudent->count()}} học viên,
                                    có {{$courseStudent->where('status','=',1)->count()}} học viên nghỉ học
                                </p>
                            </div>
                            <div class="card-footer">
                                @if(count($scores)>0)
                                    <div class="float-right">
                                        <button type="button" id="btnSave" class="btn btn-primary"><i
                                                class="fas fa-save"></i> Nhập điểm
                                        </button>
                                    </div>
                                @endif

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
                $('#btnSave').on('click', function () {
                    let scores = $('#frmMark :input[type="number"]:not(:disabled)');
                    $('#frmMark').submit();
                });
                $('#frmMark :input[type="number"]:not(:disabled)').on('keydown', function (e) {
                    if (e.key === 'F5')
                        e.preventDefault();
                });
                $('#frmMark :input[type="number"]:not(:disabled)').on('input', function () {
                    // Lấy giá trị nhập vào
                    var inputValue = $(this).val();

                    // Chuyển đổi giá trị thành số thực (decimal)
                    var floatValue = parseFloat(inputValue);

                    // Kiểm tra nếu giá trị không nằm trong khoảng từ 0 đến 10
                    if (isNaN(floatValue) || floatValue < 0 || floatValue > 10) {
                        // Nếu không hợp lệ, đặt giá trị về null
                        $(this).val(0);

                    }
                });

                function isValidExcelFile(file) {
                    const allowedExtensions = ['.xls', '.xlsx'];
                    const fileName = file.name.toLowerCase();
                    return allowedExtensions.some(ext => fileName.endsWith(ext));
                }

                $('#btnImport').on('click', function () {
                    const selectedFile = $('#fileImport')[0].files[0];
                    if (selectedFile && isValidExcelFile(selectedFile)) {
                       $('#frmImport').submit();
                    } else {
                        alert('Vui lòng chọn một tệp Excel hợp lệ.');
                    }
                });
            </script>
    @endpush

