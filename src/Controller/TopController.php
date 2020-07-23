<?php
namespace App\Controller;

use App\Controller\AppController;

class TopController extends AppController {
  public function initialize() {
    $this->name = 'Top';
    $this->viewBuilder()->setLayout('Main');
  }

  public function index() {

  }
}