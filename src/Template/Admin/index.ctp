<input type="text" class="admin-text">
<button class="btn btn-success admin-btn">送信</button>

<?= $this->Form->create(null,['action'=>'csv']) ?>
<?= $this->Form->submit('送信') ?>
<?= $this->Form->end() ?>