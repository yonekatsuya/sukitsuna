<?php
namespace App\Controller;

use App\Controller\AppController;

class AdminController extends AppController {
  public function initialize() {
    $this->name = 'Admin';
    $this->viewBuilder()->setLayout('Main');
  }

  public function index() {

  }
}