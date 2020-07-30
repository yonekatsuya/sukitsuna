<?php
namespace App\Controller;

use App\Controller\AppController;

class MoviesController extends AppController {
  public function initialize() {
    parent::initialize();
    $this->name = 'Movies';
    $this->autoRender = false;
  }

  public function store() {
    // ログインチェック
    if (isset($_SESSION['name'])) {
      if (!($_SESSION['id'] == 1079030440323833857)) {
        $this->redirect(['controller'=>'top','action','index']);
      } else {
        $movie = $this->Movies->newEntity($this->request->getData());
        $this->Movies->save($movie);
      }
    } else {
      $this->redirect(['controller'=>'top','action'=>'index']);
    }
  }

  public function delete() {
    if (isset($_SESSION['name'])) {
      if (!($_SESSION['id'] == 1079030440323833857)) {
        $this->redirect(['controller'=>'top','action','index']);
      } else {
        $id = $this->request->getData('movie-delete-hidden');
        $movie = $this->Movies->get($id);
        $this->Movies->delete($movie);
        $this->redirect($this->referer(['controller'=>'top','action'=>'index']));
      }
    } else {
      $this->redirect(['controller'=>'top','action'=>'index']);
    }
  }

}