@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Tạo đợt nhập điểm</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'sessionMarks.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('session_marks.fields')
                </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Lưu lại</button>
                <a href="{{ route('sessionMarks.index') }}" class="btn btn-default">Huỷ</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('third_party_scripts')
    <script>
        $(function() {

            $('#datetime').daterangepicker(
                {
                    startDate: moment(),
                    endDate: moment().add(2 ,'weeks'),
                    minDate: moment(),
                    locale: {
                        applyLabel: "Đồng ý",
                        cancelLabel: 'Hủy',
                        customRangeLabel: 'Tùy chỉnh',
                        format: 'DD/MM/Y'
                    },


                },
            );
            $('#courses').select2({
                ajax: {
                    url: '{{route('courses.search')}}',
                    dataType: 'json'
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                }
            });
        }
        )
    </script>
@endpush
