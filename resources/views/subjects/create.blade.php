@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Thêm môn học</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'subjects.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('subjects.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Lưu lại', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('subjects.index') }}" class="btn btn-default">Hủy bỏ</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
