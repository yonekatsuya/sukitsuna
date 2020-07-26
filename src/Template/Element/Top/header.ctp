<header class="bg-info">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-3 h-100 d-flex align-items-center">
          <?= $this->Html->link('スキツナ','/top',['class'=>'a-none header-logo']) ?>
        </div>
        <div class="col-9 h-100 d-flex align-items-center justify-content-end">
          <div class="row">
            <?= $this->Html->link('HOME','/top',['class'=>'btn btn-primary mx-2']) ?>
            <button class="btn btn-primary mx-2 header-search">検索</button>

            <div class="dropdown mx-2">
              <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" type="button" id="sakamitiButton" aria-haspopup="true" aria-expanded="false">坂道グループ</button>
              <div class="dropdown-menu" aria-labelledby="sakamitiButton">
                <?= $this->Html->link('乃木坂46',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'乃木坂46']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('欅坂46',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'欅坂46']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('日向坂46',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'日向坂46']],['class'=>'dropdown-item']) ?>
              </div>
            </div>

            <div class="dropdown mx-2">
              <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" type="button" id="wackButton" aria-haspopup="true" aria-expanded="false">WACK</button>
              <div class="dropdown-menu" aria-labelledby="wackButton">
                <?= $this->Html->link('BiSH',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'BiSH']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('GANG PARADE',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'GANG PARADE']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('GO TO THE BEDS',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'GO TO THE BEDS']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('PARADISES',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'PARADISES']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('BiS',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'BiS']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('EMPiRE',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'EMPiRE']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('CARRY LOOSE',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'CARRY LOOSE']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('PEDRO',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'PEDRO']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('豆柴の大群',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'豆柴の大群']],['class'=>'dropdown-item']) ?>
                <?= $this->Html->link('WAgg',['controller'=>'Top','action'=>'search','?'=>['groupName'=>'WAgg']],['class'=>'dropdown-item']) ?>
              </div>
            </div>

            <?php if (isset($_SESSION['name'])) : ?>
              <div class="dropdown">
                <?= $this->Html->image($_SESSION['profile_image_url'],['class'=>'header-profile dropdown-toggle','width'=>40,'alt'=>'プロフィール画像','data-toggle'=>'dropdown']) ?>
                <div class="dropdown-menu">
                  <?= $this->Html->link('プロフィール','#',['class'=>'dropdown-item header-profile-btn']) ?>
                  <?= $this->Html->link('ログアウト','#',['class'=>'dropdown-item','data-toggle'=>'modal','data-target'=>'#testModal2']) ?>
                </div>
              </div>
            <?php else : ?>
              <button class="btn btn-primary mx-2 header-register-login">登録/ログイン</button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </header>