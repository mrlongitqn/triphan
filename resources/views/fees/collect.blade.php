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

        #courses_list li {
            cursor: pointer;
        }

        .mm, .ff, .status {
            width: 20px;
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
            $('input[name="studentId"]').val(id);
            $.get('{{route('courseStudents.listCourse')}}/' + id, function (res) {
                if (res.success) {
                    $('#courses_list').empty();
                    if (res.data.length > 0) {
                        res.data.forEach(function (v) {
                            $('#courses_list').append('<li data-id="' + v.id + '" data-fee="' + v.fee + '" class="list-group-item">' +
                                v.course + ' (' + v.fee.toLocaleString() + ') - ' + moment(v.created_at).format('d/M/Y'));
                        })
                    } else {
                        $('#courses_list').append('<p class="p2 text-center">Chưa có lớp</p>');
                    }
                }
            })
        })

        $(document).on('click', '#courses_list li', function () {
            $('#courses_list li').removeClass('active');
            $(this).addClass('active');
            let id = $(this).data('id');
            $('input[name="courseStudentId"]').val(id);
            console.log(id);
            let fee = $(this).data('fee');
            $.get('{{route('fees.getListFee')}}/' + id, function (data) {
                $('#feeTable tbody').empty();
                data.list.months.forEach(function (m, i) {
                    $('#feeTable tbody').append(
                        '<tr>' +
                        '<td><input data-index=' + i + '  class="mm form-control" type="checkbox" name="' + m + '" /></td>' +
                        '<td>' + m + '</td>' +
                        '<td><input type="number" class="feeNum form-control" name="fee_' + m + '" value="' + ((i === 0 && data.list.remain > 0) ? data.list.remain : fee) + '" /></td>' +
                        '<td><input type="text" class="form-control" name="note_' + m + '" value="" /></td>' +
                        '<td><input data-index=' + i + '  class="ff form-control" type="checkbox" name="full_' + m + '" /></td>' +
                        '</tr>'
                    );
                });

            });
        });
        var array_index = [];
        var array_month = [];
        var total = 0;
        var discount = 0;
        var amount = 0;
        var pay = 0;
        var remain = 0;
        $(document).on('change', '#feeTable .mm', function () {
            let c = $(this);
            var isChecked = $(this).prop("checked");
            $('input[name="full_' + c.attr('name') + '"]').prop("checked", "checked");
            if (isChecked) {
                array_index.push(c.data('index'));
                array_month.push(c.attr('name'));
            } else {
                array_index = array_index.filter((num) => num !== c.data('index'));
                array_month = array_month.filter((m) => m !== c.attr('name'));
            }
            total = calTotal(array_month);

        });
        $(document).on('change', '.feeNum', function () {
            calTotal(array_month);
        });
        $(document).on('change', '#discount', function () {
            calTotal(array_month);
        });

        $(document).on('change', '#pay', function () {
            let p = parseInt($(this).val());
            remain = p - amount ;
            $('#remain').text(remain.toLocaleString());
        });

        function round(so) {
            return Math.ceil(so / 1000) * 1000;
        }

        $('#save').on('click', function () {
            if (array_index.length === 0) {
                alert('Vui lòng chọn tháng cần thu');
                return;
            }
            let ok = kiemTraDaySoBatDauTu0(array_index);
            if (!ok) {
                alert('Vui lòng chọn tháng cần thu liên tục');
                return;
            }
            $('#formSave').submit();
        });

        function calTotal(arr) {
            let t = 0;
            arr.forEach(m => {
                t = t + parseInt($('input[name="fee_' + m + '"]').val());
                console.log($('input[name="fee_' + m + '"]').val());
            });
            total = t;
            $('#total').text(t.toLocaleString());
            discount = parseInt($('#discount').val());
            amount = round(total * (1 - discount / 100));
            $('#amount').text(amount.toLocaleString());
            pay = amount;
            $('#pay').val(pay);
            remain = 0;
            $('#remain').text('0');
            return t;
        }


        function kiemTraDaySoBatDauTu0(arr) {
            arr.sort((a, b) => a - b);
            for (let i = 0; i < arr.length; i++) {
                if (arr[i] !== i) {
                    return false;
                }
            }
            return true;
        }

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
                                        <select name="student_code" style="width: 100%"
                                                id="student_code">
                                            @if(isset($student))
                                                <option value="{{$student->id}}" selected="selected">{{$student->code}}
                                                    - {{$student->fullname}}</option>
                                            @endif

                                        </select>
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
                                            <li data-id="{{$course->id}}" data-fee="{{$course->fee}}"
                                                data-course="{{$course->course_id}}" class="list-group-item
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
                        <form id="formSave" action="{{route('fees.saveCollect')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="studentId"/>
                            <input type="hidden" name="courseStudentId"/>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">THU HỌC PHÍ</h3>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 250px;">

                                        </div>
                                    </div>
                                </div>

                                <div class="card-body table-responsive p-0">
                                    <table id="feeTable" class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tháng</th>
                                            <th>Số tiền</th>
                                            <th>Ghi chú</th>
                                            <th>Đã thu đủ</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                    <div class="col-sm-4 offset-8">
                                        <table class="table">
                                            <tr>
                                                <td><label for="total">Tổng cộng</label></td>
                                                <td><strong id="total">0</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="discount">Chiết khấu</label>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number" max="100" min="0"
                                                           value="0" name="discount"
                                                           id="discount">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="amount">Phải trả</label>
                                                </td>
                                                <td>
                                                    <strong id="amount">0</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="pay">Khách đưa</label>
                                                </td>
                                                <td>
                                                    <input class="form-control" min="0" type="number" value="0"
                                                           name="pay"
                                                           id="pay">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="remain">Tiền thừa</label>
                                                </td>
                                                <td>
                                                    <strong id="remain">0</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="right">
                                <div class="form-group">

                                    <label>Ghi chú</label>
                                    <input type="text" class="form-control" name="note">
                                </div>
                                <div class="form-group">

                                    <label for="payment_type">Hình thức thanh toán</label>
                                    <select id="payment_type" name="payment_type" class="form-control">
                                        <option value="0">Tiền mặt</option>
                                        <option value="1">Chuyển khoản</option>
                                        <option value="2">Quẹt thẻ</option>
                                    </select>
                                </div>

                                <button type="button" id="save" class="btn btn-warning">Thu học phí</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
@push('page_script')

@endpush

