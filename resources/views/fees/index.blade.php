@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fees</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('fees.collect') }}">
                        Thu học phí
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
                @include('fees.table')

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
    <div class="modal fade" id="modal-cancel" style="display: none;" aria-hidden="true">
        <form action="{{route('fees.cancel')}}">


        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn hủy hóa đơn: <span id="fee_code"></span></p>
                    <input type="hidden" name="code" value="">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" id="btn_cancel" class="btn btn-primary">Xác nhận hủy</button>
                </div>
            </div>

        </div>
        </form>
    </div>
@endsection
@push('third_party_scripts')
    <script>

        function PopupWindow(url, title, w, h) {
            var left = (screen.width / 2) - (w / 2);
            var top = (screen.height / 2) - (h / 2);
            var win = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            if (win) {
                win.focus();

            } else {
                alert('Please allow popups for this website');
            }
        }
        @if(Session::has('bill_id'))
        var url = "<?= route('fees.getBill', Session::get('bill_id')) ?>";
        PopupWindow(url, 'Print Bill', 1000, 800);
        @endif
        function viewDetail(invoiceId) {
            let loadingHtml = '<div style="text-align: center;padding: 20px;font-size: 35px;"><i class="fa fa-spinner fa-spin"></i></div>';
            let $model = $('#model_show');
            let $modalContent = $model.find('.modal-body');

            $model.modal('show');
            $modalContent.html(loadingHtml);

            fetch('{{route('fees.show')}}/'+invoiceId)
                .then(function (response) {
                    return response.text()
                })
                .then(function (data) {
                    $modalContent.html(data);
                })
        }
        $(document).on('click', '.btn-cancel', function (){
           let code = $(this).data('id');
           $('input[name="code"]').val(code);
            let modal = $('#modal-cancel');
            modal.modal('show');
        });
    </script>
@endpush
