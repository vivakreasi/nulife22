<div class="modal fade" id="memberMasalah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">News Update</h4>
            </div>
            <div class="modal-body">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $news->content->title; ?>
                    </header>
                    <div class="panel-body">
                        <div>
                            <?php echo $news->content->sort_desc ?>
                        </div>
                        <br>
                        <div style="text-align: center;">
                            <img width="500" src="{{$news->content->image_url}}" alt="{{$news->content->title}}">
                        </div>
                        <br>
                        <div>
                            <?php echo $news->content->desc; ?>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <a href="{{ route('view.member.news', ['id' => $news->content->id]) }}" class="btn btn-default" type="button">Close Reading</a>
            </div>
        </div>
    </div>
</div>
