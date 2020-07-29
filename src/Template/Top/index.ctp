<div class="row top-title my-5 justify-content-center">
  <?php if (isset($all)) : ?>
    <h3>全ての動画一覧（<span class="title-hit-num"><?= $count ?></span>件）</h3>
  <?php else : ?>
    <div>
      <?php if (!empty($keyword)) : ?>
        <h3 class="text-center">「<span class="title-group-name"><?= $keyword ?></span>」でHITした動画一覧（<span class="title-hit-num"><?= $count ?></span>件）</h3>
      <?php else : ?>
        <h3 class="text-center">「<span class="title-group-name"><?= $groupName ?></span>」の動画一覧（<span class="title-hit-num"><?= $count ?></span>件）</h3>
      <?php endif; ?>
      <?php if (!empty($otherInfo)) : ?>
        <h5 class="text-muted text-center"><?= $otherInfo ?></h5>
      <?php endif; ?>
      <?php if (!empty($groupNameArray)) : ?>
        <h4 class="text-muted text-center">~~
          <?php foreach($groupNameArray as $item) : ?>
            <?= '「' . $item . '」' ?>
          <?php endforeach; ?>  
        ~~</h4>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>

<?php foreach ($movies as $movie) : ?>
  <div class="row p-3 mb-5 movie-area movie-common-area">
    <div class="col-7 h-100 d-flex align-items-center">
      <div class="h-100 d-flex align-items-center"><?= $movie->link ?></div>
    </div>
    <div class="col-5 h-100">
      <div class="h-75 mt-4 movie-title-description">
        <p class="font-weight-bold border-bottom border-success">タイトル</p>
        <p class="font-weight-bold"><?= $movie->title ?></p>
        <p class="font-weight-bold border-bottom border-success">再生数</p>
        <p><?= $this->Number->format($movie->view_count) ?></p>
        <p class="font-weight-bold border-bottom border-success">高評価数</p>
        <p><?= $this->Number->format($movie->like_count) ?></p>
        <p class="font-weight-bold border-bottom border-success">低評価数</p>
        <p><?= $this->Number->format($movie->dislike_count) ?></p>
        <p class="font-weight-bold border-bottom border-success">コメント数</p>
        <p><?= $this->Number->format($movie->comment_count) ?></p>
      </div>
      <div class="row justify-content-around">
        <?php if (!in_array($movie->id,$login_user_like_movies)) : ?>
          <button class="btn btn-info p-3 like-btn">好き</button>
        <?php else : ?>
          <button class="btn p-3 like-btn unlike-btn">好き解除</button>
        <?php endif; ?>
        <a href="/sukitsuna/moviesusers/likeUserIndex?id=<?= $movie->id ?>" class="btn btn-warning p-3 like-index-btn">好き一覧(<span><?= count($movie->users) ?></span>)</a>
        <input type="hidden" class="hidden" value="<?= $movie->id ?>">

        <!-- 管理者にのみ表示する -->
        <?php if (isset($_SESSION['name'])) : ?>
          <?php if ($_SESSION['id'] == 1079030440323833857) : ?>
            <button class="btn btn-danger movie-delete" data-toggle="modal" data-target="#testModal1">削除</button>
          <?php endif; ?>
        <?php endif; ?>
        <!--  -->

      </div>
    </div>
  </div>
<?php endforeach; ?>

<nav aria-label="ページネーション" class="paging-flag m-5">
  <ul class="pagination justify-content-center">
    <?= $this->Paginator->first(' << ',['class'=>'page-item']) ?>
    <?= $this->Paginator->numbers([
      'modulus' => 4
    ]) ?>
    <?= $this->Paginator->last(' >> ',['class'=>'page-item']) ?>
  </ul>
</nav>