@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Cập nhật ca (lớp) học</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($courseSession, ['route' => ['courseSessions.update', $courseSession->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('course_sessions.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Lưu lại', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('courseSessions.index',[
            'course'=>$courseSession->course_id
        ]) }}" class="btn btn-default">Hủy bỏ</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
