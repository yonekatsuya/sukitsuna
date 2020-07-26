<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class UsersMoviesController extends AppController {
  public function initialize() {
    $this->name = 'UsersMovies';
    $this->autoRender = false;
    $this->UsersMovies = TableRegistry::get('usersmovies');
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

}