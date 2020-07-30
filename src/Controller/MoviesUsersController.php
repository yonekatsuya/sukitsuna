<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class MoviesUsersController extends AppController {
  public function initialize() {
    parent::initialize();
    $this->name = 'MoviesUsers';

    $this->autoRender = false;

    $this->MoviesUsers = TableRegistry::get('moviesusers');
    $this->Movies = TableRegistry::get('movies');
    $this->Users = TableRegistry::get('users');

    $this->getLoginUserLikeMovies->getLoginuserLikeMovies();
  }

  // 「好き」ボタン押下時の処理（moviesusersテーブルに「誰がどの動画を好き登録したか」という情報を保存）
  public function store() {
    if ($this->request->is('post')) {
      $likeEntity = $this->MoviesUsers->newEntity($this->request->getData());
      $this->MoviesUsers->save($likeEntity);
    } else {
      // ログイン済みでないユーザーの場合、現在ページにリダイレクトする
      $this->Flash->set('ログインしてください。');
      $this->redirect($this->referer(['controller'=>'top','action'=>'index']));
    }
  }

  // 「好き解除」ボタン押下時の処理（対象レコードの削除）
  public function delete() {
    if (isset($_SESSION['name'])) {
      $user_id = $this->request->getData('user_id');
      $movie_id = $this->request->getData('movie_id');
      $this->MoviesUsers->deleteAll(['user_id'=>$user_id,'movie_id'=>$movie_id]);
    } else {
      $this->redirect(['controller'=>'top','action'=>'index']);
    }
  }

  // 対象ユーザーが好き登録している動画一覧をJSON形式で取得する
  public function loginUserLikeMovies() {
    // 対象ユーザーの取得
    $user = $this->Users->find()->where(['id'=>$this->request->getQuery('userId')])->contain(['Movies'])->toArray();

    // 「何件目からの」データを取得するか、リクエストパラメータの値から計算
    $x = $this->request->getQuery('dispNum');

    if (count($user[0]->movies) < 10) {
      // 対象ユーザーの好き登録動画数が10件未満であれば、動画数分だけループを回せるよう準備
      $from = 0;
      $to = count($user[0]->movies) - 1;
    } else {
      $toNum = $x * 10;
      // 例えば好き登録動画数が33件で、31件目から40件目までのデータを取得するようリクエストがあった場合、31件目から33件目までの残り動画数分のループを回せるよう準備
      if (($toNum - (int)count($user[0]->movies)) >= 1) {
        $flg = 10 - ($toNum - (int)count($user[0]->movies));
        $from = $x * 10 - 10;
        $to = $from + ($flg - 1);
      } else {
        // 好き登録動画数の末尾が「0」の場合、10件分の動画を取得するためのループを回せるよう準備
        $from = $x * 10 - 10;
        $to = $x * 10 - 1;
      }
    }

    // 指定数分の動画を取得する
    $likeMoviesArray = [];
    for ($i = $from;$i <= $to;$i++) {
      $likeMoviesArray[] = $this->Movies->find()->where(['id'=>$user[0]->movies[$i]->id])->contain(['Users'])->toArray();
    }

    // 各動画情報をJSON形式に変換するように配列を作成する
    foreach ($likeMoviesArray as $movie) {
      $movies['item'][] = [
        "id" => $movie[0]->id,
        "link" => $movie[0]->link,
        "title" => $movie[0]->title,
        "description" => $movie[0]->description,
        'view_count' => $movie[0]->view_count,
        'like_count' => $movie[0]->like_count,
        'dislike_count' => $movie[0]->dislike_count,
        'comment_count' => $movie[0]->comment_count,
        'users' => count($movie[0]->users)
      ];
    }

    $movies['count'] = count($user[0]->movies);

    // 対象ユーザーの好き登録動画数が10未満であれば、最下部までスクロールした後に新たにデータを取得する処理を行わないようメタ情報を追加
    if (count($user[0]->movies) < 10) {
      $movies['addRecordFlg'] = false;
    } else {
      $movies['addRecordFlg'] = true;
    }

    $json = json_encode($movies,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    $this->response->body($json);
  }

  // 対象動画を好き登録しているユーザーの一覧を取得する
  public function likeUserIndex() {
    // 専用のテンプレートファイルをレンダリングする
    $this->autoRender = true;
    $this->viewBuilder()->setLayout('Main');

    // 取得する動画のidを取得する
    $id = $this->request->getQuery('id');

    // 対象動画を取得する
    $likeMovie = $this->Movies->find()->where(['id'=>$id])->contain(['Users'])->first();

    // 対象動画を好き登録しているユーザーの数を取得する
    $count = count($likeMovie->users);

    // 対象動画を好き登録しているユーザー一覧を取得する
    $likeUsers = $likeMovie->users;

    $this->set(compact('likeUsers','count','likeMovie'));
  }

}