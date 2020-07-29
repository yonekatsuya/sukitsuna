<div class="like-user-profile-modal">
  <div class="close">×</div>

  <div class="d-flex w-100 h-100">
    <div class="like-twitter-profile h-100 w-25">
      <div class="container like-twitter-profile-content my-4 h-100">
        <div>
          <?= $this->Html->image('cake.icon.png',['class'=>'like-user-profile-image-url d-block mx-auto','width'=>'70%','alt'=>'プロフィール画像']) ?>
        </div>
        <div class="logo d-flex align-items-center justify-content-center mt-3">
          <i class="fab fa-twitter text-info"></i>
        </div>
        <div class="mt-3">
          <?= $this->Html->link('Twitterアカウント','#',['class'=>'like-user-screen-name btn btn-info text-white font-weight-bold d-flex align-items-center justify-content-center','target'=>'_blank']) ?>
        </div>

        <input type="hidden" class="hidden-like-twitter-user-id" value="">
        <div class="like-twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">名前</div>
          <div class="like-user-name info mt-2"></div>
        </div>
        <div class="like-twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">居住地</div>
          <div class="like-user-location info mt-2"></div>
        </div>
        <div class="like-twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">自己紹介</div>
          <div class="like-user-description info mt-2"></div>
        </div>
        <div class="like-twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">フォロー数</div>
          <div class="like-user-friends-count info mt-2"></div>
        </div>
        <div class="like-twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">フォロワー数</div>
          <div class="like-user-followers-count info mt-2"></div>
        </div>
        <div class="like-twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">リンク</div>
          <div class="like-user-other-url info mt-2"><?= $this->Html->link("","#",['target'=>'_blank']) ?></div>
        </div>
      </div>
    </div>
  
    <div class="like-login-user-like-movie h-100 w-75">
      <div class="container my-3">
        <div class="row d-flex align-items-center justify-content-center my-5">
          <h2 class="title font-weight-bold">好き動画一覧（<span></span>件）</h2>
        </div>

        <div class="like-login-user-like-movie-dom-wrap">
          <div class="like-login-user-like-movie-dom"></div>
          <div class="like-login-user-like-movie-dom-dummy" style="height:10px;"></div>
        </div>

      </div>
    </div>
  </div>
</div>