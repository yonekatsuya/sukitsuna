<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class AdminController extends AppController {
  public function initialize() {
    $this->name = 'Admin';
    $this->viewBuilder()->setLayout('Main');
    parent::initialize();

    $this->Movies = TableRegistry::get('movies');
    $this->MoviesUsers = TableRegistry::get('movies_users');

    $this->getLoginUserLikeMovies->getLoginuserLikeMovies();
  }

  public function index() {
    if (isset($_SESSION['name'])) {
      if (!($_SESSION['id'] == 1079030440323833857)) {
        $this->redirect(['controller'=>'top','action','index']);
      }
    } else {
      $this->redirect(['controller'=>'top','action'=>'index']);
    }
  }

  public function csv() {
    $movies = $this->Movies->find()->select(['title','group_name','view_count','like_count','dislike_count','comment_count'])->toArray();
    $header = ['タイトル','グループ名','再生数','高評価数','低評価数','コメント数'];
    $datas = [];
    foreach ($movies as $movie) {
      $datas[] = [
        $movie->title,
        $movie->group_name,
        $movie->view_count,
        $movie->like_count,
        $movie->dislike_count,
        $movie->comment_count
      ];
    }

    $temp_dir = sys_get_temp_dir();
    $temp_csv_file_path = tempnam($temp_dir,'temp_csv');

    $fp = fopen($temp_csv_file_path, 'w');
    fputcsv($fp,$header);

    foreach ($datas as $data) {
      $row = [
        $data[0],
        $data[1],
        $data[2],
        $data[3],
        $data[4],
        $data[5],
      ];
      fputcsv($fp,$data);
    }
    fclose($fp);

    $this->response = $this->response->withType('csv');
    return $this->response->withFile(
      $temp_csv_file_path,
      [
        'download' => true,
        'name' => 'hoge.csv'
      ]
    );
  }
}