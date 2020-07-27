<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class UsersMoviesController extends AppController {
  public function initialize() {
    parent::initialize();
    $this->name = 'UsersMovies';
    session_start();
    $this->autoRender = false;
    $this->UsersMovies = TableRegistry::get('usersmovies');
    $this->Movies = TableRegistry::get('movies');
    $this->Users = TableRegistry::get('users');

    $this->set('movie',$this->Movies->newEntity());

    // ログインユーザーが好き登録している動画一覧を取得する（「好き」ボタンの表示切り替えに使用）
    if (isset($_SESSION['name'])) {
      $login_id = $_SESSION['uniqueid'];
      $entities = $this->UsersMovies->find()->where(['user_uniqueid'=>$login_id])->select(['movie_id'])->all()->toArray();
      $login_user_like_movies = [];
      foreach ($entities as $item) {
        $login_user_like_movies[] = $item->movie_id;
      }
      $this->set('login_user_like_movies',$login_user_like_movies);
    } else {
      $this->set('login_user_like_movies',[]);
    }
  }

  public function store() {
    $user_uniqueid = $this->request->getData('userId');
    $movie_id = $this->request->getData('movieId');

    $entity = $this->UsersMovies->newEntity();

    $entity->user_uniqueid = $user_uniqueid;
    $entity->movie_id = $movie_id;

    $this->UsersMovies->save($entity);
  }

  public function delete() {
    $user_uniqueid = $this->request->getData('userId');
    $movie_id = $this->request->getData('movieId');

    $this->UsersMovies->deleteAll(['user_uniqueid'=>$user_uniqueid,'movie_id'=>$movie_id]);
  }

  public function loginUserLikeMovies() {
    $login_id = $this->request->getQuery('userId');
    
    $loginUserLikeMovies = $this->UsersMovies->find()->where(['user_uniqueid'=>$login_id])->select(['movie_id'])->toArray();

    $movieIdArray = [];
    foreach ($loginUserLikeMovies as $item) {
      $movieIdArray[] = $item->movie_id;
    }

    $array = [];
    foreach ($movieIdArray as $id) {
      $array[] = $this->Movies->find()->where(['id'=>$id])->toArray();
    }

    $movies = [];

    foreach ($array as $item) {
      $movies[] = [
        "id" => $item[0]->id,
        "link" => $item[0]->link,
        "title" => $item[0]->title,
        "description" => $item[0]->description
      ];
    }

    $json = json_encode($movies,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    echo $json;
    
  }

  public function likeUserIndex() {
    $this->autoRender = true;
    $this->viewBuilder()->setLayout('Main');

    $id = $this->request->getQuery('id');

    // 対象動画を取得する
    $movie = $this->Movies->find()->where(['id'=>$id])->first();

    // 対象動画を好き登録しているユーザーの数を取得する
    $count = $this->UsersMovies->find()->where(['movie_id'=>$id])->count();

    $users = $this->UsersMovies->find()->where(['movie_id'=>$id])->toArray();

    $array = [];
    foreach ($users as $user) {
      $array[] = $user->user_uniqueid;
    }
    
    $likeUsers = [];
    foreach ($array as $item) {
      $likeUsers[] = $this->Users->find()->where(['uniqueid'=>$item])->toArray();
    }

    $this->set('likeUsers',$likeUsers);
    $this->set('count',$count);
    $this->set('likeMovie',$movie);
  }

}