<!DOCTYPE html>
<html lang="ja">
<head>
  <?= $this->Html->charset() ?>
  <title>
    <?= $this->fetch('title') ?>
  </title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <?php
  echo $this->Html->css('main.css');
  echo $this->fetch('meta');
  echo $this->fetch('css');
  echo $this->fetch('script');
  ?>
</head>

<body>
  <?php if (isset($_SESSION['name'])) : ?>
    <input type="hidden" class="hidden-login-id" value="<?= $_SESSION['id'] ?>">
    <?php $login_user_like_movies_string = implode(',',$login_user_like_movies) ?>
    <input type="hidden" class="hidden-login_user-like-movies" value="<?= $login_user_like_movies_string ?>">
  <?php endif; ?>

  <?= $this->element('Top/header') ?>

  <div class="w-100 text-center bg-warning"><?= $this->Flash->render() ?></div>

  <div class="container">
      <?= $this->fetch('content') ?>
  </div>

  <?= $this->element('Top/footer') ?>

  <?= $this->element('Top/search') ?>

  <?= $this->element('Top/scrollBtn') ?>

  <?= $this->element('Movies/delete') ?>
  <?= $this->element('Users/delete') ?>

  <?= $this->element('Top/registerLogin') ?>

  <?php if (isset($_SESSION['name'])) : ?>
    <?= $this->element('Users/profile') ?>
  <?php endif; ?>

  <?= $this->element('Users/likeUserProfile') ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>

  <?php
  echo $this->Html->script('main.js');
  ?>
</body>
</html>