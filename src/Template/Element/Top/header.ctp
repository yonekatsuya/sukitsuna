<header class="bg-info">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-3 h-100 d-flex align-items-center">
          <?= $this->Html->link('スキツナ','/top',['class'=>'a-none']) ?>
        </div>
        <div class="col-9 h-100 d-flex align-items-center justify-content-end">
          <div class="row">
            <?= $this->Html->link('HOME','/top',['class'=>'btn btn-primary mx-2']) ?>
            <button class="btn btn-primary mx-2 header-search">検索</button>

            <div class="dropdown mx-2">
              <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" type="button" id="sakamitiButton" aria-haspopup="true" aria-expanded="false">坂道グループ</button>
              <div class="dropdown-menu" aria-labelledby="sakamitiButton">
                <?= $this->Html->link('乃木坂46','#',['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('欅坂46','#',['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('日向坂46','#',['class'=>'dropdown-item']) ?>
              </div>
            </div>

            <div class="dropdown mx-2">
              <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" type="button" id="wackButton" aria-haspopup="true" aria-expanded="false">WACK</button>
              <div class="dropdown-menu" aria-labelledby="wackButton">
                <?= $this->Html->link('Bish','#',['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('Go to the beds','#',['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('Paradises','#',['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('Bis','#',['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('Carry loose','#',['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('Wagg','#',['class'=>'dropdown-item']) ?>
              </div>
            </div>

            <button class="btn btn-primary mx-2">登録/ログイン</button>
          </div>
        </div>
      </div>
    </div>
  </header>