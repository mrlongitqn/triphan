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
            $.get('{{route('fees.feeByStudent')}}/' + id, function (res) {
                $('#feeTable tbody').empty();
                if (res.success) {
                    console.log(res);
                    if (res.data.length > 0) {
                        res.data.forEach(function (v, i) {
                            $('#feeTable tbody').append(
                                '<tr>' +
                                '<td><input class="mm form-control" type="checkbox" name="fee_ids[]" data-amount="' + v.amount + '"  value="' + v.id + '"/></td>' +
                                '<td>' + moment(v.created_at).format('D/M/Y') + '</td>' +
                                '<td>' + v.name + '</td>' +
                                '<td>' + v.course + '</td>' +
                                '<td>' + v.note + '</td>' +
                                '<td>' + v.amount.toLocaleString() + '</td>' +
                                '</tr>'
                            );
                        })
                    } else {
                        $('#feeTable tbody').append('<tr><td colspan="6"> <p class="p2 text-center">Chưa có lớp</p></td></tr>');
                    }
                }
            })
        });
        var total = 0;
        var amount = 0;
        $(document).on('change', '#feeTable .mm', function () {
            let c = $(this);
            var isChecked = $(this).prop("checked");
            if (isChecked) {
                total = total + c.data('amount');
            } else {
                total = total - c.data('amount');
            }
            $('#total').html(total.toLocaleString());
        });
        $('#save').on('click', function () {
            let s = $('#student_code').val();
            if (s=== null || s.length === 0) {
                alert('Vui lòng chọn học viên');
                return;
            }
            if (total === 0) {
                alert('Vui lòng chọn Hóa đơn cần trả học phí');
                return;
            }
            amount = parseInt($('#amount').val())
            if (amount === 0 || isNaN(amount)) {
                alert('Vui lòng nhập số tiền cần hoàn trả');
                return;
            }
            let reason = $('#reason').val();
            if (reason==='' || reason.length === 0) {
                alert('Vui lòng nhập nội dung hoàn trả');
                return;
            }
            $('#formSave').submit();
        });

    </script>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Trả học phí</h1>
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

                    <div class="col-sm-12">
                        <form id="formSave" action="{{route('refunds.store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="studentId"/>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">DANH SÁCH 5 HỌC PHÍ GẦN NHẤT</h3>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 250px;">

                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <table id="feeTable" class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Thời gian</th>
                                            <th>Người thu</th>
                                            <th>Khóa học</th>
                                            <th>Ghi chú</th>
                                            <th>Số tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="total">Tổng cộng: </label>
                                            <strong id="total">0</strong>

                                        </div>

                                        <div class="form-group">

                                            <label for="amount">Số tiền cần trả</label>
                                            <input id="amount" type="number" class="form-control" name="amount">
                                        </div>
                                        <div class="form-group">

                                            <label for="reason">Ghi chú</label>
                                            <input id="reason" type="text" class="form-control" name="reason">
                                        </div>
                                        <button type="button" id="save" class="btn btn-warning">Trả học phí</button>
                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
@push('page_script')

@endpush

