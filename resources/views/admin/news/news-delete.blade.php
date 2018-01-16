
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Edit Company Bank</h4>
</div>

<div class="modal-body" style="max-height: 400px; overflow: auto;">
    <h2 class="modal-title" id="myModalLabel">Are you sure want to delete this NEWS!!!</h2>
    <table class="table table-bordered table-hover responsive" id="tbl-nulife">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Sort Desc</th>
            </tr>
        </thead>
        <tbody>
            <tr class="warning">
                 <td style="text-align: center;"><img src="{{$data->image_url}}" style="height:100px;max-width: 134px;"></td>
                <td>{{$data->title}}</td>
                <td><?php echo $data->sort_desc; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <a class="btn btn-danger" href="/admin/delete/news/{{$data->id}}/delete">Delete</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
            

