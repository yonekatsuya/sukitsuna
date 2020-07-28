<div class="user-profile-modal">
  <div class="close">×</div>

  <div class="d-flex w-100 h-100">
    <div class="twitter-profile h-100 w-25">
      <div class="container twitter-profile-content my-4 h-100">
        <div>
          <?= $this->Html->image($_SESSION['profile_image_url'],['class'=>'d-block mx-auto','width'=>'70%','alt'=>'プロフィール画像']) ?>
        </div>
        <div class="logo d-flex align-items-center justify-content-center mt-3">
          <i class="fab fa-twitter text-info"></i>
        </div>
        <div class="mt-3">
          <?php $twitterUrl = 'https://mobile.twitter.com/' . $_SESSION['screen_name'] ?>
          <?= $this->Html->link('Twitterアカウント',$twitterUrl,['class'=>'btn btn-info text-white font-weight-bold d-flex align-items-center justify-content-center','target'=>'_blank']) ?>
        </div>

        <div class="twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">名前</div>
          <div class="info mt-2"><?= $_SESSION['name'] ?></div>
        </div>
        <div class="twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">居住地</div>
          <div class="info mt-2"><?= $_SESSION['location'] ?></div>
        </div>
        <div class="twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">自己紹介</div>
          <div class="info mt-2"><?= $_SESSION['description'] ?></div>
        </div>
        <div class="twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">フォロー数</div>
          <div class="info mt-2"><?= $_SESSION['friends_count'] ?></div>
        </div>
        <div class="twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">フォロワー数</div>
          <div class="info mt-2"><?= $_SESSION['followers_count'] ?></div>
        </div>
        <div class="twitter-user-info my-4">
          <div class="font-weight-bold border-bottom border-success">リンク</div>
          <div class="info mt-2"><?= $this->Html->link($_SESSION['other_url'],$_SESSION['other_url'],['target'=>'_blank']) ?></div>
        </div>
      </div>
    </div>
  
    <div class="login-user-like-movie h-100 w-75">
      <div class="container my-3">
        <div class="row d-flex align-items-center justify-content-center my-5">
          <h2 class="title font-weight-bold">好き動画一覧（<span></span>件）</h2>
        </div>

        <div class="login-user-like-movie-dom"></div>

      </div>
    </div>
  </div>
</div>