<div class="modal fade" id="testModal1" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><div class="modal-title" id="myModalLabel">削除確認画面</div></h4>
            </div>
            <div class="modal-body">
                <label>本当にこの動画を削除しますか？</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                <?= $this->Form->create(null,['url'=>['controller'=>'Movies','action'=>'delete']]) ?>
                <?= $this->Form->hidden('movie-delete-hidden',['value'=>'','class'=>'movie-delete-hidden']) ?>
                <?= $this->Form->button('はい',['class'=>'btn btn-danger']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>