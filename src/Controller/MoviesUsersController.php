<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class MoviesUsersController extends AppController {
  public function initialize() {
    parent::initialize();
    $this->name = 'MoviesUsers';
    session_start();
    $this->autoRender = false;
    $this->MoviesUsers = TableRegistry::get('moviesusers');
    $this->Movies = TableRegistry::get('movies');
    $this->Users = TableRegistry::get('users');

    $this->set('movie',$this->Movies->newEntity());

    // ログインユーザーが好き登録している動画一覧を取得する（「好き」ボタンの表示切り替えに使用）
    if (isset($_SESSION['name'])) {
      $login_id = $_SESSION['id'];
      $entities = $this->MoviesUsers->find()->where(['user_id'=>$login_id])->select(['movie_id'])->all()->toArray();
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
    if ($this->request->is('post')) {
      $user_id = $this->request->getData('userId');
      $movie_id = $this->request->getData('movieId');
  
      $entity = $this->MoviesUsers->newEntity();
  
      $entity->user_id = $user_id;
      $entity->movie_id = $movie_id;
  
      $this->MoviesUsers->save($entity);
    } else {
      $url = $this->request->getQuery('query');
      $url = urldecode($url);
      $this->Flash->set('ログインしてください。');
      $this->redirect($url);
    }
  }

  public function delete() {
    $user_id = $this->request->getData('userId');
    $movie_id = $this->request->getData('movieId');

    $this->MoviesUsers->deleteAll(['user_id'=>$user_id,'movie_id'=>$movie_id]);
  }

  // 対象ユーザーが好き登録している動画の一覧をJSON形式で取得する
  public function loginUserLikeMovies() {
    $login_id = $this->request->getQuery('userId');

    // 対象ユーザーの好き登録している動画の数を取得する
    $count = $this->MoviesUsers->find()->where(['user_id'=>$login_id])->count();
    
    $loginUserLikeMovies = $this->MoviesUsers->find()->where(['user_id'=>$login_id])->select(['movie_id'])->toArray();

    $movieIdArray = [];
    foreach ($loginUserLikeMovies as $item) {
      $movieIdArray[] = $item->movie_id;
    }

    $array = [];
    foreach ($movieIdArray as $id) {
      $array[] = $this->Movies->find()->where(['id'=>$id])->contain(['Users'])->toArray();
    }
    $this->log($array);

    $movies = [];

    foreach ($array as $item) {
      $movies['item'][] = [
        "id" => $item[0]->id,
        "link" => $item[0]->link,
        "title" => $item[0]->title,
        "description" => $item[0]->description,
        'view_count' => $item[0]->view_count,
        'like_count' => $item[0]->like_count,
        'dislike_count' => $item[0]->dislike_count,
        'comment_count' => $item[0]->comment_count,
        'users' => count($item[0]->users)
      ];
    }

    $movies['count'] = $count;

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
    $count = $this->MoviesUsers->find()->where(['movie_id'=>$id])->count();

    $users = $this->MoviesUsers->find()->where(['movie_id'=>$id])->toArray();

    $array = [];
    foreach ($users as $user) {
      $array[] = $user->user_id;
    }
    
    $likeUsers = [];
    foreach ($array as $item) {
      $likeUsers[] = $this->Users->find()->where(['id'=>$item])->toArray();
    }

    $this->set('likeUsers',$likeUsers);
    $this->set('count',$count);
    $this->set('likeMovie',$movie);
  }

}