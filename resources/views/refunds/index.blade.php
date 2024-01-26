@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hoàn trả học phí</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('refunds.create') }}">
                        Tạo mới hoàn trả
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
                @include('refunds.table')

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="model_show" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Chi tiết</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

                </div>
            </div>

        </div>

    </div>
@endsection
@push('third_party_scripts')
    <script>
        function viewDetail(invoiceId) {
            let loadingHtml = '<div style="text-align: center;padding: 20px;font-size: 35px;"><i class="fa fa-spinner fa-spin"></i></div>';
            let $model = $('#model_show');
            let $modalContent = $model.find('.modal-body');

            $model.modal('show');
            $modalContent.html(loadingHtml);

            fetch('{{route('refunds.show')}}/'+invoiceId)
                .then(function (response) {
                    return response.text()
                })
                .then(function (data) {
                    $modalContent.html(data);
                })
        }
    </script>
@endpush

