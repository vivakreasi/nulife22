<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Detail All Bonus {{ $dataUser->name }} {{ $dataUser->userid }}</h4>
</div>
<div class="modal-body" style="max-height: 400px; overflow: auto;">
  <table class="table table-bordered table-hover responsive" id="tbl-nulife">
        <thead>
            <tr>
                <th>Total Bonus Sponsor</th>
                <th>Total Bonus Pairing</th>
                <th>Total Bonus Upgrade</th>
                <th>Summary Old Bonus</th>
                <th>Withdrawal</th>
                <th>Outstanding WD</th>
                <th>Balance</th>
                <th>Total Bonus</th>
            </tr>
        </thead>
        <tbody>
            <tr class="warning">
                <td>Rp. {{$dataBonus->bonus_sponsor}}</td>
                <td>Rp. {{$dataBonus->bonus_pairing}}</td>
                <td>Rp. {{$dataBonus->bonus_upgrade_b}}</td>
                <td>Rp. {{$dataBonus->old_bonus}}</td>
                <td>Rp. {{$dataBonus->withdrawal}}</td>
                <td>Rp. {{$dataBonus->outstanding_wd}}</td>
                <td>Rp. {{$dataBonus->balance}}</td>
                <td>Rp. {{$dataBonus->total_bonus}}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

