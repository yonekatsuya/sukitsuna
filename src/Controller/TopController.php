<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class TopController extends AppController {
  public function initialize() {
    $this->name = 'Top';
    parent::initialize();
    session_start();

    $this->viewBuilder()->setLayout('Main');

    $this->Movies = TableRegistry::get('movies');
    $this->MoviesUsers = TableRegistry::get('movies_users');

    $this->paginate = [
      'limit' => 10,
      'order' => ['view_count'=>'desc'],
      'contain' => ['Users']
    ];

    // ログインユーザーが好き登録している動画一覧を取得する（「好き」ボタンの表示切り替えに使用）
    if (isset($_SESSION['name'])) {
      $user_like_movies = $this->MoviesUsers->find()->where(['user_id'=>$_SESSION['id']])->select(['movie_id'])->all()->toArray();
      $login_user_like_movies = [];
      foreach ($user_like_movies as $item) {
        $login_user_like_movies[] = $item->movie_id;
      }
      // ログイン済みの場合のみ、「好き」と「好き解除」ボタンの表示分岐処理を行う（そのための準備）
      $this->set('login_user_like_movies',$login_user_like_movies);
    } else {
      $this->set('login_user_like_movies',[]);
    }
  }

  public function index() {
    // デフォルトで乃木坂46の動画一覧を表示する
    $this->paginate['conditions'] = ['group_name' => '乃木坂46'];
    $movies = $this->paginate($this->Movies);
    $count = $this->Movies->find()->where(['group_name' => '乃木坂46'])->count();
    $this->set(compact('movies','count'));
    $this->set('groupName','乃木坂46');
    $this->set('otherInfo','再生回数が多い順');
  }

  // ヘッダーの各グループ名押下時の処理（グループ名に合致するレコードをだけを取得してビューに渡す）
  public function search() {
    $groupName = $this->request->getQuery('groupName');
    $this->paginate['conditions'] = ['group_name' => $groupName];
    $count = $this->Movies->find()->where(['group_name'=>$groupName])->count();
    $movies = $this->paginate($this->Movies);
    $this->set(compact('movies','count','groupName'));
    $this->set('otherInfo','再生回数が多い順');
    $this->render('index');
  }

  // サイドバーの検索モーダルでのチェックに応じた動画を取得する
  public function sideSearch() {
    // 検索フォームから送られてきた値を取得する
    $data = $this->request->getQuery();

    $checkData = [];
    // チェックボックスにチェックが付いていた項目を取得する
    foreach ($data as $key => $value) {
      if ($data[$key] === '1') {
        $checkData[] = $key;
      }
    }

    // チェックボックスにチェックが付いている項目数に応じて別々の検索条件で動画と動画数を取得する
    $this->paginate = $this->__otherCheck($data,$this->paginate);
    if (count($checkData) === 0) {
      $count = $this->Movies->find('all')->count();
      $movies = $this->paginate($this->Movies);
      // 0件の場合は全動画を表示するため、表示を切り替える判定値として「all」をセットする
      $this->set('all','all');
    } elseif (count($checkData) === 1) {
      $this->paginate['conditions'] = ['group_name' => $checkData[0]];
      $count = $this->Movies->find()->where(['group_name'=>$checkData[0]])->count();
      $movies = $this->paginate($this->Movies);
    } elseif(count($checkData) >= 2) {
      $this->paginate['conditions']['or'] = [];
      for ($i = 0;$i < count($checkData);$i++) {
        $this->paginate['conditions']['or'][] = ['group_name'=>$checkData[$i]];
        $whereAry[] = ['group_name'=>$checkData[$i]];
      }
      $count = $this->Movies->find()->where(['OR'=>$whereAry])->count();
      $movies = $this->paginate($this->Movies);
    }

    // チェックが付いた数に応じて、見出しに表示するグループ名を分岐する
    if (count($checkData) > 1) {
      $groupName = '複数グループ';
      $groupNameArray = [];
      foreach ($checkData as $key => $value) {
        $groupNameArray[] = $value;
      }
    } elseif (count($checkData) === 1) {
      foreach ($checkData as $key => $value) {
        $groupName = $value;
      }
      $groupNameArray = '';
    } else {
      $groupName = '';
      $groupNameArray = '';
    }


    $this->set(compact('groupNameArray','movies','count','groupName'));
    $this->set('otherInfo',$this->__getOtherInfo($data));
    $this->render('index');
  }

  public function keywordsearch() {
    // 入力キーワードの取得
    $keyword = $this->request->getQuery('keyword');

    // タイトルか説明文かグループ名に入力キーワードを含む動画一覧を取得するよう設定
    $this->paginate['conditions'] = ['or'=>['title like'=>"%${keyword}%",'description like'=>"%${keyword}%",'group_name like'=>"%${keyword}%"]];

    // HITした動画数の取得
    $count = $this->Movies->find()->where(['title like'=>"%${keyword}%"])->orWhere(['description like'=>"%${keyword}%"])->orWhere(['group_name like'=>"%${keyword}%"])->count();

    // HITした動画の取得
    $movies = $this->paginate($this->Movies);
    
    $this->set(compact('movies','count','keyword'));
    $this->set('groupName','');
    $this->set('otherInfo','再生回数が多い順');

    $this->render('index');
  }


  private function __otherCheck($data,$paginate) {
    switch ($data['other-search']) {
      case 'viewCount':
        $paginate['order'] = ['view_count' => 'desc'];
        break;
      case 'likeCount':
        $paginate['order'] = ['like_count' => 'desc'];
        break;
      case 'dislikeCount':
        $paginate['order'] = ['dislike_count' => 'desc'];
        break;
      case 'commentCount':
        $paginate['order'] = ['comment_count' => 'desc'];
        break;
    }
    return $paginate;
  }

  private function __getOtherInfo($data) {
    switch ($data['other-search']) {
      case 'viewCount':
        $otherInfo = '再生回数が多い順';
        break;
      case 'likeCount':
        $otherInfo = '高評価数が多い順';
        break;
      case 'dislikeCount':
        $otherInfo = '低評価数が多い順';
        break;
      case 'commentCount':
        $otherInfo = 'コメント数が多い順';
        break;
    }
    return $otherInfo;
  }
}