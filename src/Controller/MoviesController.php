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
    $movie->link = $this->request->data('link');
    $movie->title = $this->request->data('title');
    $movie->description = $this->request->data('description');
    $movie->channel_title = $this->request->data('channelTitle');
    $movie->view_count = $this->request->data('viewCount');
    $movie->like_count = $this->request->data('likeCount');
    $movie->dislike_count = $this->request->data('dislikeCount');
    $movie->comment_count = $this->request->data('commentCount');

    if ($this->Movies->save($movie)) {
      $this->log('ok');
    }
  }
}