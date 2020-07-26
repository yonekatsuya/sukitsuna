<?php
namespace App\Controller;

use App\Controller\AppController;

class MoviesController extends AppController {
  public function initialize() {
    $this->name = 'Movies';
    $this->autoRender = false;
  }

  public function store() {
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

  public function delete() {
    $id = $this->request->getData('movie-delete-hidden');
    $movie = $this->Movies->get($id);
    $this->Movies->delete($movie);
    $this->redirect(['controller'=>'Top','action'=>'index']);
  }

  public function likestore() {
    $this->autoRender = false;
    $entity = $this->Movies->find()->contain(['Users'])->all();
    dd($entity);
  }
}