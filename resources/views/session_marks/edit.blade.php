@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Cập nhật đợt nhập điểm</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($sessionMark, ['route' => ['sessionMarks.update', $sessionMark->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('session_marks.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Lưu lại', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('sessionMarks.index') }}" class="btn btn-default">Huỷ</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('third_party_scripts')
    <script>

        $('#datetime').daterangepicker(
            {
                minDate: moment(),
                locale: {
                    applyLabel: "Đồng ý",
                    cancelLabel: 'Hủy',
                    customRangeLabel: 'Tùy chỉnh',
                    format: 'DD/MM/Y'
                }
            },
            // function (start, end) {
            //
            //     $('#datetime').val(start.format('DD/MM/Y') + ' - ' + end.format('DD/MM/Y'));
            // }
        );
        $('#courses').select2({
            ajax: {
                url: '{{route('courses.search')}}',
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
    </script>
@endpush
