<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Structure Data {{ $dataUser->name }}</h4>
</div>
<div class="modal-body" style="max-height: 400px; overflow: auto;">
  <table class="table table-bordered table-hover responsive" id="tbl-nulife">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Type User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataStruktur as $row)
                <tr>
                    <td>{{ $row->userid }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->desc }}</td>
                </tr>
            @endforeach
            <tr class="warning">
                <td>{{ $dataUser->userid }}</td>
                <td>{{ $dataUser->name }}</td>
                <td>{{ $dataUser->desc }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

