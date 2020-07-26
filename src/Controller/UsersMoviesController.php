<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class UsersMoviesController extends AppController {
  public function initialize() {
    $this->name = 'UsersMovies';
    $this->autoRender = false;
    $this->UsersMovies = TableRegistry::get('usersmovies');
    $this->Movies = TableRegistry::get('movies');
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

}