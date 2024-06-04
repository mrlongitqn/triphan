@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>Học viên</h1>
                </div>
                <div class="col-sm-6">
                    <form id="frmImport" action="{{route('student.import')}}" method="post" style="width:400px; float: right"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token"
                               value="{{csrf_token()}}">

                        <div class="input-group">
                            <div class="input-group-append" style="cursor: pointer">
                                <span id="btnDownload" class="input-group-text">Tải mẫu   <i class="fas fa-download"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input custom-file-sm"
                                       name="fileImport"
                                       id="fileImport" accept=".xls, .xlsx">
                                <label class="custom-file-label " for="exampleInputFile">Choose
                                    file</label>
                            </div>
                            <div style="cursor: pointer" class="input-group-append">
                                <span id="btnImport" class="input-group-text">Import <i class="fas fa-upload"></i></span>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-sm-2">
                    <a class="btn btn-primary float-right"
                       href="{{ route('students.create') }}">
                        Thêm học viên
                    </a>
                </div>


            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body pl-2 pr-2 pt-0 pb-0">
                @include('students.table')

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('third_party_scripts')
    <script>
        $('#btnDownload').on('click', function (){

            window.location.href = '/templates/ImportHocVienMau.xlsx';
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
