<?php
namespace App\Controller;

use App\Controller\AppController;
use Abraham\TwitterOAuth\TwitterOAuth;

class UsersController extends AppController {
  public function initialize() {
    parent::initialize();
    $this->name = 'Users';
    $this->autoRender = false;
    // $this->loadComponent('Auth');
    // $this->Auth->allow(['twitter','store']);
    session_start();
  }

  public function twitter() {
    // まず、twitter apiにリクエストを送る上での準備を行う（APIキー、シークレットキー、アクセストークン、アクセスシークレットトークンを指定）
    $connection = new TwitterOAuth('waKJ1oGENeH7qFrWBXulfBKKA', 'OWlpPc58ihra4nxRcmvj0Fk9AOiqrgNyuMDRnDtv8LoHmNzklZ','1253962680781557761-PHf2tL71dAJEl4ufk994PXfy8aqAz7', 'hEavIrGvaTFPT8HVWCEr5bEfqh47mDdux7DJwSX9l5YP3');
    // twitter apiにリクエストを送るときに必要なワンタイムトークンを生成する
    $request_token = $connection->oauth('oauth/request_token', ['oauth_callback' => 'http://localhost:8888/sukitsuna/users/store']);
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    // ワンタイムトークンをクエリパラメータにセットしたtwitter apiへのリクエストurlを生成する
    $oauthUrl = $connection->url('oauth/authorize', ['oauth_token' => $_SESSION['oauth_token']]);
    // TwitterAPIを叩く
    $this->redirect($oauthUrl);
  }

  public function store() {
    $twitter_connect = new TwitterOAuth('waKJ1oGENeH7qFrWBXulfBKKA', 'OWlpPc58ihra4nxRcmvj0Fk9AOiqrgNyuMDRnDtv8LoHmNzklZ', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $access_token = $twitter_connect->oauth('oauth/access_token', ['oauth_verifier' => $_GET['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']]);

    $user_connect = new TwitterOAuth('waKJ1oGENeH7qFrWBXulfBKKA', 'OWlpPc58ihra4nxRcmvj0Fk9AOiqrgNyuMDRnDtv8LoHmNzklZ',$access_token['oauth_token'], $access_token['oauth_token_secret']);
    // Twitterアカウントのユーザー情報を取得する
    $user_info = $user_connect->get('account/verify_credentials');

    // ユーザー情報を取得する。登録済みであればユーザー情報が返ってきて、未登録であれば空の配列が返ってくる
    $user = $this->Users->find()->where(['id'=>$user_info->id])->toArray();
    
    // TwitterAPIから取得したユーザーが、既に一度登録済みかどうかを判定
    if (count($user)) {
      $this->__setLogin($user_info);
    } else {
      // まだ登録済みでなければ、新規登録してログイン状態にする。
      $user = $this->Users->newEntity();
      $user->id = $user_info->id;
      $user->name = $user_info->name;
      $user->screen_name = $user_info->screen_name;
      $user->location = $user_info->location;
      $user->description = $user_info->description;
      $user->other_url = $user_info->url;
      $user->followers_count = $user_info->followers_count;
      $user->friends_count = $user_info->friends_count;
      $user->favourites_count = $user_info->favourites_count;
      $user->profile_image_url = $user_info->profile_image_url;

      if ($this->Users->save($user)) {
        $this->__setLogin($user_info);
      }
    }
    $this->Flash->set('ログインに成功しました。');
    return $this->redirect(['controller'=>'top','action'=>'index']);
  }

  // ログアウト処理
  public function delete() {
    if (isset($_SESSION['name'])) {
      $_SESSION = [];
      session_destroy();
      $this->Flash->set('ログアウトしました。');
      return $this->redirect(['controller'=>'top','action'=>'index']);
    } else {
      $this->redirect(['controller'=>'top','action'=>'index']);
    }
  }


  // セッション変数に値を格納してログイン状態にする
  private function __setLogin($user_info) {
    $_SESSION['id'] = $user_info->id;
    $_SESSION['name'] = $user_info->name;
    $_SESSION['screen_name'] = 'https://mobile.twitter.com/' . $user_info->screen_name;
    $_SESSION['location'] = $user_info->location;
    $_SESSION['description'] = $user_info->description;
    $_SESSION['other_url'] = $user_info->url;
    $_SESSION['followers_count'] = $user_info->followers_count;
    $_SESSION['friends_count'] = $user_info->friends_count;
    $_SESSION['favourites_count'] = $user_info->favourites_count;
    $_SESSION['profile_image_url'] = $user_info->profile_image_url;
  }

}