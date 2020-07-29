<?php
namespace App\Controller;

use App\Controller\AppController;

class MoviesController extends AppController {
  public function initialize() {
    $this->name = 'Movies';
    $this->autoRender = false;
    session_start();
  }

  public function store() {
    // ログインチェック
    if (isset($_SESSION['name'])) {
      if (!($_SESSION['id'] == 1079030440323833857)) {
        $this->redirect(['controller'=>'top','action','index']);
      } else {
        $movie = $this->Movies->newEntity();
        $movie->link = $this->request->getData('link');
        $movie->title = $this->request->getData('title');
        $movie->description = $this->request->getData('description');
        $movie->channel_title = $this->request->getData('channelTitle');
        $movie->view_count = $this->request->getData('viewCount');
        $movie->like_count = $this->request->getData('likeCount');
        $movie->dislike_count = $this->request->getData('dislikeCount');
        $movie->comment_count = $this->request->getData('commentCount');
        $movie->group_name = $this->request->getData('groupName');

        if ($this->Movies->save($movie)) {
          $this->log('ok');
        }
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
        $this->log($id);
        $movie = $this->Movies->get($id);
        $this->Movies->delete($movie);
        $this->redirect(['controller'=>'Top','action'=>'index']);
      }
    } else {
      $this->redirect(['controller'=>'top','action'=>'index']);
    }
  }

}