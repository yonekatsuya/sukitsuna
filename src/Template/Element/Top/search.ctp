<div class="search-side">
  <div class="search-side-content">
    <div class="close">×</div>
    <div class="container">
        <?= $this->Form->create(null,['url'=>['controller'=>'top','action'=>'keywordsearch'],'type'=>'get']) ?>
          <div class="py-3 input-group">
            <?= $this->Form->text('keyword',['placeholder'=>'検索キーワードを入力する','class'=>'form-control']) ?>
            <div class="input-group-append">
              <?= $this->Form->submit('検索',['class'=>'btn btn-info']) ?>
            </div>
          </div>
        <?= $this->Form->end() ?>
      <div class="pt-3 pl-5 group-set">
        <?= $this->Form->create(null,['type'=>'get','url'=>['controller'=>'top','action'=>'sideSearch']]) ?>
        <p class="group-item"><?= $this->Form->checkbox('乃木坂46',['id'=>'nogizaka']) ?>
        <?= $this->Form->label('nogizaka','乃木坂46') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('欅坂46',['id'=>'keyakizaka']) ?>
        <?= $this->Form->label('keyakizaka','欅坂46') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('日向坂46',['id'=>'hinatazaka']) ?>
        <?= $this->Form->label('hinatazaka','日向坂46') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('BiSH',['id'=>'bish']) ?>
        <?= $this->Form->label('bish','BiSH') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('GO TO THE BEDS',['id'=>'gotothebeds']) ?>
        <?= $this->Form->label('gotothebeds','GO TO THE BEDS') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('PARADISES',['id'=>'paradises']) ?>
        <?= $this->Form->label('paradises','PARADISES') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('GANG PARADE',['id'=>'gangparade']) ?>
        <?= $this->Form->label('gangparade','GANG PARADE') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('BiS',['id'=>'bis']) ?>
        <?= $this->Form->label('bis','BiS') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('EMPiRE',['id'=>'empire']) ?>
        <?= $this->Form->label('empire','EMPiRE') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('CARRY LOOSE',['id'=>'carryloose']) ?>
        <?= $this->Form->label('carryloose','CARRY LOOSE') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('豆柴の大群',['id'=>'mameshiba']) ?>
        <?= $this->Form->label('mameshiba','豆柴の大群') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('PEDRO',['id'=>'pedro']) ?>
        <?= $this->Form->label('pedro','PEDRO') ?></p>
        <p class="group-item"><?= $this->Form->checkbox('WAgg',['id'=>'wagg']) ?>
        <?= $this->Form->label('wagg','WAgg') ?></p>
      </div>
      <div class="pl-5 mt-3 other-set">
        <?= $this->Form->radio('other-search',
          [
            ['text'=>'再生回数が多い順','value'=>'viewCount'],
            ['text'=>'高評価数が多い順','value'=>'likeCount'],
            ['text'=>'低評価数が多い順','value'=>'dislikeCount'],
            ['text'=>'コメント数が多い順','value'=>'commentCount']
          ],
          ['label'=>true,'value'=>'viewCount']) ?>
      </div>
      <div class="w-100 mt-3">
        <?= $this->Form->submit('検索',['class'=>'btn btn-info text-white font-weight-bold w-75 d-block mx-auto']) ?>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>