<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Detail PIN {{$data->name}} {{$data->userid}}</h4>
</div>
<div class="modal-body" style="max-height: 400px; overflow: auto;">
  <table class="table table-bordered table-hover responsive" id="tbl-nulife">
        <thead>
            <tr>
                <th>Transfered PIN</th>
                <th>Active PIN</th>
                <th>Used PIN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">{{ $data->transfered_pin }}</td>
                <td style="text-align: center;">{{ $data->active_pin }}</td>
                <td style="text-align: center;">{{ $data->used_pin }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

