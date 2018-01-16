
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Edit Company Bank</h4>
</div>

<div class="modal-body" style="max-height: 400px; overflow: auto;">
    <h4 class="modal-title" id="myModalLabel">Old Data</h4>
    <table class="table table-bordered table-hover responsive" id="tbl-nulife">
        <thead>
            <tr>
                <th>Bank Name</th>
                <th>No. Account</th>
                <th>Account Name</th>
            </tr>
        </thead>
        <tbody>
            <tr class="warning">
                <td style="text-align: center;">{{$data->bank_name}}</td>
                <td style="text-align: center;">{{$data->bank_account}}</td>
                <td style="text-align: center;">{{$data->bank_account_name}}</td>
            </tr>
        </tbody>
    </table>
    <h4 class="modal-title" id="myModalLabel">Edit New Data</h4>
    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.company.bank.edit.post') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-md-3">
                        <h5>Bank Name :</h5>
                    </div>
                    <div class="col-md-9">
                        <select name="bank_id" class="form-control">
                            @foreach($listBank as $row)
                                <option value="{{ $row['code'] }}">{{ $row['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h5>Bank Account :</h5>
                    </div>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="bank_account" value="{{$data->bank_account}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h5>Account Name :</h5>
                    </div>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="bank_account_name" value="{{$data->bank_account_name}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <button class="btn btn-info" type="submit" style="padding-left: 20px;padding-right: 20px;">Save</button>
            </div>
            <div class="hide">
                <input type="hidden" id="id" value="{{$data->id}}" name="id">
            </div>
        </div>
    </form> 
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
            

