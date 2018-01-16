@extends('layouts.main')

@section('header')
    @include('layouts.header')
@endsection

@section('vendor_style')
    <link href="{{ asset('assets/js/vendor/bootstrap-fileinput-master/css/fileinput.css') }}" rel="stylesheet" />
@endsection

@section('content')
<style type="text/css">
    .table > thead > tr > th {
        text-align: center;
    }
</style>
<section class="panel">
    <div class="panel-body">
        <table class="table table-hover responsive">
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>PIN Amount</th>
                    <th>PIN Price</th>
                    <th>Status</th>
                    <th>Status Date</th>
                </tr>
            </thead>
            <tbody>
                @if (!$orders->isEmpty())
                    @foreach($orders as $row)
                        <tr>
                            <td>{{ date('Y-m-d', strtotime($row->tgl_order)) }}</td>
                            <td style="text-align: center;">{{ $row->x_jmlpin }}</td>
                            <td style="text-align: right;">Rp 
                                @if (intval($row->harus_transfer) > 0)
                                    {{ number_format($row->harus_transfer, 0, ',', '.') }}
                                @else
                                    {{ number_format($row->transfer_pin, 0, ',', '.') }}
                                @endif
                                ,-
                            </td>
                            <td>
                                @if ($row->status == 3)
                                    Success
                                @elseif ($row->status == 5)
                                    Wait for Admin Approval
                                @else
                                    Not Transfer Yet
                                @endif
                            </td>
                            <td>
                                @if ($row->status == 4)
                                    <a class="btn btn-info open-upload-dialog" data-toggle="modal" data-id="{{ $row->id }}" href="#uploadPaymentConf"> Payment Confirmation </a>
                                @elseif ($row->status == 5)
                                    <a class="btn btn-primary open-viewimage-dialog" data-toggle="modal" data-image="{{ $row->bukti_transfer }}" href="#proof_transfer"> View proof of transfer file </a>
                                @else
                                    <a href="#" class="btn btn-success"> Confirmed </a>
                                @endif
                            </td>
                            <td>
                                @if ($row->status == 5)
                                    @if (!empty($row->tgl_approve))
                                        {{ date('Y-m-d', strtotime($row->tgl_approve)) }}
                                    @else
                                        @if (!empty($row->tgl_konfirmasi))
                                            {{ date('Y-m-d', strtotime($row->tgl_konfirmasi)) }}
                                        @else
                                            {{ date('Y-m-d', strtotime($row->tgl_order)) }}
                                        @endif
                                    @endif
                                @elseif ($row->status == 3)
                                    @if (!empty($row->tgl_konfirmasi))
                                        {{ date('Y-m-d', strtotime($row->tgl_konfirmasi)) }}
                                    @else
                                        {{ date('Y-m-d', strtotime($row->tgl_order)) }}
                                    @endif
                                @else
                                    {{ date('Y-m-d', strtotime($row->tgl_order)) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center;">No data available in table</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</section>
<div class="modal fade" id="proof_transfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Proof of Transfer</h4>
            </div>
            <div class="modal-body">
                <img id="myImage" src="" style="width: 100%;">
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="uploadPaymentConf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Payment Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Upload your proof of transfer document.</p>
                <form role="form" id="frmUpload" method="post" enctype="multipart/form-data" action="{{ route('planc.uploadbukti') }}">
                    {{ csrf_field() }}
                    <input type="hidden" id="order_id" name="order_id" value="">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="form-group">
                                <input id="file" name="file" type="file" multiple="false" class="file" data-overwrite-initial="false" data-min-file-count="2">
                            </div>
                        </div>
                    </section>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/vendor/bootstrap-fileinput-master/js/fileinput.js') }}" type="text/javascript"></script>
    <script>
        $(document).on("click", ".open-upload-dialog", function () {
            var myOrderId = $(this).data('id');
            $(".modal-body #order_id").val( myOrderId );
        });

        $(document).on("click", ".open-viewimage-dialog", function () {
            var url = '{{ route("planc.pin.image") }}';
            var myImage = url + '?img=' + $(this).data('image');
            $('#proof_transfer img').attr('src', myImage);
        });

        $("#file").fileinput({
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            overwriteInitial: false,
            maxFileSize: 1000,
            maxFilesNum: 1
        });

    </script>
@endsection