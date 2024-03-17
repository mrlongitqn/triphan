@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Loại cột điểm: {{$markType->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('markTypeDetails.create', ['id'=>$markType->id]) }}">
                       Thêm mới
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                <table class="table">
                    <tr>
                        <td>STT</td>
                        <td>Cột số</td>
                        <td>Tên cột</td>
                        <td></td>
                    </tr>
                    @if(!$detail)
                        <tr><td colspan="4">Chưa có cột điểm nào</td></tr>
                    @else
                        @php
                        $i = 1;
                         @endphp
                        @foreach($detail as $key => $val)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$val->column_number}}</td>
                                <td>{{$val->column_name}}</td>
                                <td>
                                    <a href="{{ route('markTypeDetails.edit',['id' =>$val->id]) }}" class='btn btn-default btn-xs'>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if($i === count($detail)+1)
                                        {!! Form::open(['route' => ['markTypeDetails.destroy',$val->id], 'method' => 'delete', 'class'=>'form-inline']) !!}
                                        <div class='btn-group'>


                                            {!! Form::button('<i class="fa fa-trash"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'onclick' => "return confirm('Are you sure?')"
                                            ]) !!}
                                        </div>
                                        {!! Form::close() !!}
                                    @endif


                                </td>
                            </tr>
                        @endforeach
                    @endif

                </table>
                <div class="card-footer clearfix">
                    <div class="float-right">
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

