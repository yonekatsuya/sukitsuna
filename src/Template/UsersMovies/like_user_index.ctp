<div class="row p-3 mb-3 mt-5 movie-area">
  <div class="col-7 d-flex align-items-center">
    <p class="mt-4"><?= $likeMovie->link ?></p>
  </div>
  <div class="col-5">
    <div class="h-75 mt-4 movie-title-description">
      <p class="font-weight-bold border-bottom border-success">タイトル</p>
      <p><?= $likeMovie->title ?></p>
      <p class="font-weight-bold border-bottom border-success">説明欄</p>
      <p><?= $likeMovie->description ?></p>
    </div>
    <div class="row justify-content-around">
      <?php if (!in_array($likeMovie->id,$login_user_like_movies)) : ?>
        <button class="btn btn-info p-3 like-btn w-75">好き</button>
      <?php else : ?>
        <button class="btn p-3 like-btn unlike-btn w-75">好き解除</button>
      <?php endif; ?>
      <input type="hidden" class="hidden" value="<?= $likeMovie->id ?>">
      <!-- <button class="btn btn-danger movie-delete" data-toggle="modal" data-target="#testModal1">削除</button> -->
    </div>
  </div>
</div>

<div class="row top-title my-5 justify-content-center">
  <h3>この動画を好き登録しているユーザーの一覧（<?= $count ?>人）</h3>
</div>

<div class="row justify-content-around">
  <?php foreach ($likeUsers as $user) : ?>
    <div class="like-user-area p-4 mb-5">
      <div class="row">
        <div class="col-4">
          <?= $this->Html->image($user[0]->profile_image_url,['class'=>'like-user-image mb-3','width'=>'100%','alt'=>'プロフィール画像']) ?>
          <button class="like-user-info btn btn-info p-3 text-white font-weight-bold w-100">詳細</button>
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