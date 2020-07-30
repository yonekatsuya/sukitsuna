<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class getLoginUserLikeMoviesComponent extends Component {
  public $name = 'getLoginUserLikeMovies';
  public $controller;

  public function initialize(array $config) {
    parent::initialize($config);
    $this->controller = $this->_registry->getController();
    $this->MoviesUsers = TableRegistry::get('movies_users');
  }

  public function getLoginuserLikeMovies() {
    if (isset($_SESSION['name'])) {
      $user_like_movies = $this->MoviesUsers->find()->where(['user_id'=>$_SESSION['id']])->select(['movie_id'])->all()->toArray();
      $login_user_like_movies = [];
      foreach ($user_like_movies as $item) {
        $login_user_like_movies[] = $item->movie_id;
      }
      // ログイン済みの場合のみ、「好き」と「好き解除」ボタンの表示分岐処理を行う（そのための準備）
      $this->controller->set('login_user_like_movies',$login_user_like_movies);
    } else {
      $this->controller->set('login_user_like_movies',[]);
    }
  }

}