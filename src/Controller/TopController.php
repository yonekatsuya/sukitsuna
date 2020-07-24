<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class TopController extends AppController {
  public function initialize() {
    $this->name = 'Top';
    $this->viewBuilder()->setLayout('Main');
    $this->Movies = TableRegistry::get('movies');
  }

  public function index() {
    $movies = $this->Movies->find('all');
    $this->set('movies',$movies);
  }
}