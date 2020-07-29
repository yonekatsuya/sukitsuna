<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class AdminController extends AppController {
  public function initialize() {
    $this->name = 'Admin';
    $this->viewBuilder()->setLayout('Main');
    parent::initialize();
    session_start();

    $this->Movies = TableRegistry::get('movies');
    $this->MoviesUsers = TableRegistry::get('movies_users');

    // ログインユーザーが好き登録している動画一覧を取得する（「好き」ボタンの表示切り替えに使用）
    if (isset($_SESSION['name'])) {
      $login_id = $_SESSION['id'];
      $entities = $this->MoviesUsers->find()->where(['user_id'=>$login_id])->select(['movie_id'])->all()->toArray();
      $login_user_like_movies = [];
      foreach ($entities as $item) {
        $login_user_like_movies[] = $item->movie_id;
      }
      $this->set(compact('login_user_like_movies'));
    } else {
      $this->set('login_user_like_movies',[]);
    }
  }

  public function index() {
    if (isset($_SESSION['name'])) {
      if (!($_SESSION['id'] == 1079030440323833857)) {
        $this->redirect(['controller'=>'top','action','index']);
      }
    } else {
      $this->redirect(['controller'=>'top','action'=>'index']);
    }
  }
}