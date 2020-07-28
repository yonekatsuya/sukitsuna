<?php
namespace App\Controller;

use App\Controller\AppController;
use Abraham\TwitterOAuth\TwitterOAuth;

class UsersController extends AppController {
  public function initialize() {
    $this->name = 'Users';
    $this->autoRender = false;
    // $this->loadComponent('Auth');
    // $this->Auth->allow(['twitter','store']);
    session_start();
  }

  public function twitter() {
    // まず、twitter apiにリクエストを送る上での準備を行う
    $connection = new TwitterOAuth('waKJ1oGENeH7qFrWBXulfBKKA', 'OWlpPc58ihra4nxRcmvj0Fk9AOiqrgNyuMDRnDtv8LoHmNzklZ','1253962680781557761-PHf2tL71dAJEl4ufk994PXfy8aqAz7', 'hEavIrGvaTFPT8HVWCEr5bEfqh47mDdux7DJwSX9l5YP3');
    // twitter apiにリクエストを送るときに必要なワンタイムトークンを生成する
    $request_token = $connection->oauth('oauth/request_token', ['oauth_callback' => 'http://localhost:8888/sukitsuna/users/store']);
    // Cache::write('oauth_token', $request_token['oauth_token']);
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    // Cache::write('oauth_token_secret', $request_token['oauth_token_secret']);
    // ワンタイムトークンをクエリパラメータにセットしたtwitter apiへのリクエストurlを生成する
    $oauthUrl = $connection->url('oauth/authorize', ['oauth_token' => $_SESSION['oauth_token']]);
    $this->redirect($oauthUrl);
  }

  public function store() {
    $twitter_connect = new TwitterOAuth('waKJ1oGENeH7qFrWBXulfBKKA', 'OWlpPc58ihra4nxRcmvj0Fk9AOiqrgNyuMDRnDtv8LoHmNzklZ', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $access_token = $twitter_connect->oauth('oauth/access_token', array('oauth_verifier' => $_GET['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));

    $user_connect = new TwitterOAuth('waKJ1oGENeH7qFrWBXulfBKKA', 'OWlpPc58ihra4nxRcmvj0Fk9AOiqrgNyuMDRnDtv8LoHmNzklZ',$access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user_info = $user_connect->get('account/verify_credentials');
    // 「$user_info」に、Twitterアカウントの情報が収められている。

    // ユーザー情報を取得する。登録済みであればユーザー情報が返ってきて、未登録であればnull値が返ってくる
    $user = $this->Users->find()->where(['id'=>$user_info->id])->toArray();
    
    // TwitterAPIから取得したユーザーが、既に一度登録済みかどうかを判定
    if (count($user)) {
      // 対象レコードを取得する
      $user = $this->Users->find()->where(['id'=>$user_info->id])->toArray()[0];
      // セッション変数に値を格納して、ログイン状態にする
      $_SESSION['id'] = $user->id;
      $_SESSION['name'] = $user->name;
      $_SESSION['screen_name'] = 'https://mobile.twitter.com/' . $user->screen_name;
      $_SESSION['location'] = $user->location;
      $_SESSION['description'] = $user->description;
      $_SESSION['other_url'] = $user->other_url;
      $_SESSION['followers_count'] = $user->followers_count;
      $_SESSION['friends_count'] = $user->friends_count;
      $_SESSION['favourites_count'] = $user->favourites_count;
      $_SESSION['profile_image_url'] = $user->profile_image_url;
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
      $this->Users->save($user);

      // 対象レコードを取得する
      $user = $this->Users->find()->where(['id'=>$user_info->id])->toArray()[0];
      // セッション変数に値を格納して、ログイン状態にする
      $_SESSION['id'] = $user->id;
      $_SESSION['name'] = $user->name;
      $_SESSION['screen_name'] = 'https://mobile.twitter.com/' . $user->screen_name;
      $_SESSION['location'] = $user->location;
      $_SESSION['description'] = $user->description;
      $_SESSION['other_url'] = $user->other_url;
      $_SESSION['followers_count'] = $user->followers_count;
      $_SESSION['friends_count'] = $user->friends_count;
      $_SESSION['favourites_count'] = $user->favourites_count;
      $_SESSION['profile_image_url'] = $user->profile_image_url;
    }

    return $this->redirect(['controller'=>'top','action'=>'index']);
  }

  public function delete() {
    $_SESSION = [];
    session_destroy();
    return $this->redirect(['controller'=>'top','action'=>'index']);
  }

}