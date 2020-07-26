<div class="modal fade" id="testModal2" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><div class="modal-title" id="myModalLabel">ログアウト確認</div></h4>
            </div>
            <div class="modal-body">
                <label>本当にログアウトしますか？</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                <?= $this->Form->create(null,['url'=>['controller'=>'Users','action'=>'delete']]) ?>
                <?= $this->Form->button('はい',['class'=>'btn btn-danger']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>