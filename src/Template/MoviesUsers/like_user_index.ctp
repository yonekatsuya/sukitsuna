<div class="row p-3 mb-5 mt-5 movie-area movie-common-area">
  <div class="col-7 h-100 d-flex align-items-center">
    <div class="h-100 d-flex align-items-center"><?= $likeMovie->link ?></div>
  </div>
  <div class="col-5 h-100">
    <div class="h-75 mt-4 movie-title-description">
      <p class="font-weight-bold border-bottom border-success">タイトル</p>
      <p><?= $likeMovie->title ?></p>
      <p class="font-weight-bold border-bottom border-success">再生数</p>
      <p><?= $this->Number->format($likeMovie->view_count) ?></p>
      <p class="font-weight-bold border-bottom border-success">高評価数</p>
      <p><?= $this->Number->format($likeMovie->like_count) ?></p>
      <p class="font-weight-bold border-bottom border-success">低評価数</p>
      <p><?= $this->Number->format($likeMovie->dislike_count) ?></p>
      <p class="font-weight-bold border-bottom border-success">コメント数</p>
      <p><?= $this->Number->format($likeMovie->comment_count) ?></p>
    </div>
    <div class="row justify-content-around">
      <?php if (!in_array($likeMovie->id,$login_user_like_movies)) : ?>
        <button class="btn btn-info p-3 like-btn w-75">好き</button>
      <?php else : ?>
        <button class="btn p-3 like-btn unlike-btn w-75">好き解除</button>
      <?php endif; ?>
      <input type="hidden" class="hidden" value="<?= $likeMovie->id ?>">
    </div>
  </div>
</div>

<div class="row top-title my-5 justify-content-center">
  <h3 class="like-user-index-title">この動画を好き登録しているユーザーの一覧（<span><?= $count ?></span>人）</h3>
</div>

<div class="row justify-content-around user-card-area">
  <?php foreach ($likeUsers as $user) : ?>
    <div class="like-user-area p-4 mb-5">
      <div class="row">
        <div class="col-4">
          <?= $this->Html->image($user[0]->profile_image_url,['class'=>'like-user-image mb-3','width'=>'100%','alt'=>'プロフィール画像']) ?>
          <button class="like-user-info btn btn-info p-3 text-white font-weight-bold w-100">詳細</button>

          <!-- 「詳細」ボタン押下時プロフィールモーダルに渡す用のhidden一覧 -->
          <input type="hidden" class="like-user-hidden-id" value="<?= $user[0]->id ?>">
          <input type="hidden" class="like-user-hidden-profile-image-url" value="<?= $user[0]->profile_image_url ?>">
          <input type="hidden" class="like-user-hidden-screen-name" value="<?= $user[0]->screen_name ?>">
          <input type="hidden" class="like-user-hidden-name" value="<?= $user[0]->name ?>">
          <input type="hidden" class="like-user-hidden-location" value="<?= $user[0]->location ?>">
          <input type="hidden" class="like-user-hidden-description" value="<?= $user[0]->description ?>">
          <input type="hidden" class="like-user-hidden-friends-count" value="<?= $user[0]->friends_count ?>">
          <input type="hidden" class="like-user-hidden-followers-count" value="<?= $user[0]->followers_count ?>">
          <input type="hidden" class="like-user-hidden-other-url" value="<?= $user[0]->other_url ?>">

        </div>
        <div class="col-8 like-user-area-info">
          <div class="font-weight-bold border-bottom border-success">名前</div>
          <div class="name mt-2"><?= $user[0]->name ?></div>
          <div class="font-weight-bold border-bottom border-success mt-3">自己紹介</div>
          <div class="introduce mt-2"><?= $user[0]->description ?></div>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>