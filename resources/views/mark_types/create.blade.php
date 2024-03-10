@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Thêm mới loại điểm</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'markTypes.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('mark_types.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('markTypes.index') }}" class="btn btn-default">Hủy</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
