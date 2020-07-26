<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class TopController extends AppController {
  public function initialize() {
    $this->name = 'Top';
    session_start();
    $this->viewBuilder()->setLayout('Main');
    parent::initialize();
    $this->Movies = TableRegistry::get('movies');
    $this->UsersMovies = TableRegistry::get('users_movies');
    $this->loadComponent('Paginator');
    $this->paginate = [
      'limit' => 5,
      'order' => ['view_count'=>'desc'],
    ];
    $this->set('movie',$this->Movies->newEntity());

    // ログインユーザーが好き登録している動画一覧を取得する（「好き」ボタンの表示切り替えに使用）
    if (isset($_SESSION['name'])) {
      $login_id = $_SESSION['uniqueid'];
      $entities = $this->UsersMovies->find()->where(['user_uniqueid'=>$login_id])->select(['movie_id'])->all()->toArray();
      $login_user_like_movies = [];
      foreach ($entities as $item) {
        $login_user_like_movies[] = $item->movie_id;
      }
      $this->set('login_user_like_movies',$login_user_like_movies);
    } else {
      $this->set('login_user_like_movies',[]);
    }
  }

  public function index() {
    $this->paginate['conditions'] = ['group_name' => '乃木坂46'];
    $movies = $this->paginate($this->Movies);
    $count = $this->Movies->find()->where(['group_name' => '乃木坂46'])->count();
    $this->set('movies',$movies);
    $this->set('count',$count);
    $this->set('groupName','乃木坂46');
    $this->set('otherInfo','再生回数が多い順');
  }

  public function search() {
    $groupName = $this->request->getQuery('groupName');
    $this->paginate['conditions'] = ['group_name' => $groupName];
    $count = $this->Movies->find()->where(['group_name'=>$groupName])->count();
    $movies = $this->paginate($this->Movies);
    $this->set('movies',$movies);
    $this->set('count',$count);
    $this->set('groupName',$groupName);
    $this->set('otherInfo','再生回数が多い順');
    $this->render('index');
  }

  public function sideSearch() {
    // 検索フォームから送られてきた値を取得する
    $data = $this->request->getQuery();

    $array = [];
    // チェックボックスにチェックが付いていた項目を取得する
    foreach ($data as $key => $value) {
      if ($data[$key] === '1') {
        $array[] = $key;
      }
    }

    function otherCheck($data,$paginate) {
      if ($data['other-search'] === 'viewCount') {
        $paginate['order'] = ['view_count' => 'desc'];
      } elseif ($data['other-search'] === 'likeCount') {
        $paginate['order'] = ['like_count' => 'desc'];
      } elseif ($data['other-search'] === 'dislikeCount') {
        $paginate['order'] = ['dislike_count' => 'desc'];
      } elseif ($data['other-search'] === 'commentCount') {
        $paginate['order'] = ['comment_count' => 'desc'];
      }
      return $paginate;
    }



    $otherInfo = '';
    function getOtherInfo($data,$otherInfo) {
      if ($data['other-search'] === 'viewCount') {
        $otherInfo = '再生回数が多い順';
      } elseif ($data['other-search'] === 'likeCount') {
        $otherInfo = '高評価数が多い順';
      } elseif ($data['other-search'] === 'dislikeCount') {
        $otherInfo = '低評価数が多い順';
      } elseif ($data['other-search'] === 'commentCount') {
        $otherInfo = 'コメント数が多い順';
      }
      return $otherInfo;
    }


    // チェックボックスにチェックが付いている項目数に応じて別々の検索条件で動画データを取得する
    if (count($array) === 0) {
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find('all')->count();
      $movies = $this->paginate($this->Movies);
      // 0件の場合は全動画を表示するため、表示を切り替える判定値として「all」をセットする
      $this->set('all','all');
    } elseif (count($array) === 1) {
      $this->paginate['conditions'] = ['group_name' => $array[0]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 2) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 3) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 4) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 5) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 6) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]],['group_name'=>$array[5]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->orWhere(['group_name'=>$array[5]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 7) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]],['group_name'=>$array[5]],['group_name'=>$array[6]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->orWhere(['group_name'=>$array[5]])->orWhere(['group_name'=>$array[6]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 8) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]],['group_name'=>$array[5]],['group_name'=>$array[6]],['group_name'=>$array[7]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->orWhere(['group_name'=>$array[5]])->orWhere(['group_name'=>$array[6]])->orWhere(['group_name'=>$array[7]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 9) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]],['group_name'=>$array[5]],['group_name'=>$array[6]],['group_name'=>$array[7]],['group_name'=>$array[8]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->orWhere(['group_name'=>$array[5]])->orWhere(['group_name'=>$array[6]])->orWhere(['group_name'=>$array[7]])->orWhere(['group_name'=>$array[8]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 10) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]],['group_name'=>$array[5]],['group_name'=>$array[6]],['group_name'=>$array[7]],['group_name'=>$array[8]],['group_name'=>$array[9]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->orWhere(['group_name'=>$array[5]])->orWhere(['group_name'=>$array[6]])->orWhere(['group_name'=>$array[7]])->orWhere(['group_name'=>$array[8]])->orWhere(['group_name'=>$array[9]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 11) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]],['group_name'=>$array[5]],['group_name'=>$array[6]],['group_name'=>$array[7]],['group_name'=>$array[8]],['group_name'=>$array[9]],['group_name'=>$array[10]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->orWhere(['group_name'=>$array[5]])->orWhere(['group_name'=>$array[6]])->orWhere(['group_name'=>$array[7]])->orWhere(['group_name'=>$array[8]])->orWhere(['group_name'=>$array[9]])->orWhere(['group_name'=>$array[10]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 12) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]],['group_name'=>$array[5]],['group_name'=>$array[6]],['group_name'=>$array[7]],['group_name'=>$array[8]],['group_name'=>$array[9]],['group_name'=>$array[10]],['group_name'=>$array[11]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->orWhere(['group_name'=>$array[5]])->orWhere(['group_name'=>$array[6]])->orWhere(['group_name'=>$array[7]])->orWhere(['group_name'=>$array[8]])->orWhere(['group_name'=>$array[9]])->orWhere(['group_name'=>$array[10]])->orWhere(['group_name'=>$array[11]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($array) === 13) {
      $this->paginate['conditions'] = ['or' => [['group_name'=>$array[0]],['group_name'=>$array[1]],['group_name'=>$array[2]],['group_name'=>$array[3]],['group_name'=>$array[4]],['group_name'=>$array[5]],['group_name'=>$array[6]],['group_name'=>$array[7]],['group_name'=>$array[8]],['group_name'=>$array[9]],['group_name'=>$array[10]],['group_name'=>$array[11]],['group_name'=>$array[12]]]];
      $this->paginate = otherCheck($data,$this->paginate);
      $count = $this->Movies->find()->where(['group_name'=>$array[0]])->orWhere(['group_name'=>$array[1]])->orWhere(['group_name'=>$array[2]])->orWhere(['group_name'=>$array[3]])->orWhere(['group_name'=>$array[4]])->orWhere(['group_name'=>$array[5]])->orWhere(['group_name'=>$array[6]])->orWhere(['group_name'=>$array[7]])->orWhere(['group_name'=>$array[8]])->orWhere(['group_name'=>$array[9]])->orWhere(['group_name'=>$array[10]])->orWhere(['group_name'=>$array[11]])->orWhere(['group_name'=>$array[12]])->count();
      $movies = $this->paginate($this->Movies);
    }

    if (count($array) > 1) {
      $groupName = '複数グループ';
      $groupNameArray = [];
      foreach ($array as $key => $value) {
        $groupNameArray[] = $value;
      }
    } elseif (count($array) === 1) {
      foreach ($array as $key => $value) {
        $groupName = $value;
      }
      $groupNameArray = '';
    } else {
      $groupName = '';
      $groupNameArray = '';
    }


    $this->set('groupNameArray',$groupNameArray);
    $this->set('movies',$movies);
    $this->set('count',$count);
    $this->set('groupName',$groupName);
    $this->set('otherInfo',getOtherInfo($data,$otherInfo));
    $this->render('index');
  }

  public function keywordsearch() {
    $keyword = $this->request->getQuery('keyword');
    $this->log($keyword);
    $this->paginate['conditions'] = ['or'=>['title like'=>"%${keyword}%",'description like'=>"%${keyword}%",'group_name like'=>"%${keyword}%"]];

    $count = $this->Movies->find()->where(['title like'=>"%${keyword}%"])->orWhere(['description like'=>"%${keyword}%"])->orWhere(['group_name like'=>"%${keyword}%"])->count();
    $movies = $this->paginate($this->Movies);
    $this->set('movies',$movies);
    $this->set('count',$count);
    $this->set('groupName','');
    $this->set('keyword',$keyword);
    $this->set('otherInfo','再生回数が多い順');

    $this->render('index');
  }
}