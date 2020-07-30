// ログインユーザーの好き動画一覧をAPIから取得してDOM作成・表示を行う
function loginUserLikeMovies(id,num,delFlag) {
  $.ajax({
    type: 'get',
    url: 'http://localhost:8888/sukitsuna/moviesusers/loginuserlikemovies',
    dataType: 'json',
    data: {
      userId: id,
      dispNum: num
    }
  }).done(function(response) {
    console.log(response);

    // データを一件も取得出来なかった場合、処理を中断する
    if (response.item == undefined) {
      return;
    }

    // ヘッダーの「プロフィール」押下時のみ、既に表示されている動画コンポーネントを削除する（最下部までスクロールして動画を追加表示する場合はもちろん削除する必要がない）
    if (delFlag === 1) {
      $('.login-user-like-movie').scrollTop(0);
      $('.login-user-like-movie-dom').text('');
    } else {
      // 好き登録動画数が10件未満のユーザーの場合、最下部までスクロールしても追加する動画がないため、処理を中断する
      if (response.addRecordFlg == false) {
        return;
      }
    }
    
    // 対象ユーザーの好き登録動画数をタイトルにセットする
    $('.login-user-like-movie .title span').text(response.count);

    // 取得した動画の数だけ処理を回す
    response.item.forEach(function(movie) {
      // null値に対して「toLocaleString」メソッドを呼ぶとエラーになるため、回避のための分岐
      if (movie.view_count != null) {
        var viewCount = movie.view_count.toLocaleString();
      } else {
        var viewCount = 0;
      }
      if (movie.like_count != null) {
        var likeCount = movie.like_count.toLocaleString();
      } else {
        var likeCount = 0;
      }
      if (movie.dislike_count != null) {
        var dislikeCount = movie.dislike_count.toLocaleString();
      } else {
        var dislikeCount = 0;
      }
      if (movie.comment_count != null) {
        var commentCount = movie.comment_count.toLocaleString();
      } else {
        var commentCount = 0;
      }

      // ある一件の動画に関する動画コンポーネント（DOM）を作成
      var html = '<div class="row p-3 mb-5 profile-movie-area movie-common-area"><div class="col-7 h-100 d-flex align-items-center"><div class="h-100 d-flex align-items-center">' + movie.link + '</div></div><div class="col-5 h-100"><div class="h-75 mt-4 profile-movie-title-description"><p class="font-weight-bold border-bottom border-success">タイトル</p><p class="profile-title">' + movie.title + '</p><p class="font-weight-bold border-bottom border-success">再生数</p><p>' + viewCount +'</p><p class="font-weight-bold border-bottom border-success">高評価数</p><p>' + likeCount +'</p><p class="font-weight-bold border-bottom border-success">低評価数</p><p>' + dislikeCount +'</p><p class="font-weight-bold border-bottom border-success">コメント数</p><p>' + commentCount +'</p></div><div class="row justify-content-around">';

      var likeMovies = $('.hidden-login_user-like-movies').val();
      likeMovies = likeMovies.split(',');
      
      if (likeMovies.indexOf(movie.id)) {
        html += '<button class="btn p-3 like-btn unlike-btn">好き解除</button>';
      } else {
        html += '<button class="btn btn-info p-3 like-btn">好き</button>';
      }

      html += '<a href="/sukitsuna/moviesusers/likeUserIndex?id=' + movie.id + '" class="btn btn-warning p-3 like-index-btn">好き一覧（<span>' + movie.users + '</span>）</a><input type="hidden" class="hidden profile-hidden-id" value="' + movie.id + '"></div></div></div>';
      
      // 生成した動画コンポーネントのDOMを最下部に追加する
      $('.login-user-like-movie-dom').append(html);
    })

  }).fail(function(response) {
    console.log('error');
  });
}

// 何件目からの動画データを取得するかのフラグ
var getNumFlg = 1;

// ログインプロフィールモーダル内の動画領域を最下部までスクロールした時に処理を発生
$('.login-user-like-movie').scroll(function() {
  $('.login-user-like-movie')[0].onscroll = (event) => {
    if (event.target.clientHeight + event.target.scrollTop === event.target.scrollHeight) {
      // ログインユーザーidを取得する
      var userId = $('.hidden-login-id').val();
      getNumFlg++;
      // ログインユーザーの好き登録動画を取得・表示する関数
      loginUserLikeMovies(userId,getNumFlg,0);
    }
  }
});

// ヘッダーの「プロフィール」押下時の処理
$(document).on('click','.header-profile-btn',function() {
  $('.user-profile-modal').animate({
    left: 0
  },500);

  var userId = $('.hidden-login-id').val();

  loginUserLikeMovies(userId,getNumFlg,1);
});

// ログインプロフィールモーダルの閉じるボタン押下時の処理
$(document).on('click','.user-profile-modal .close',function() {
  $('.user-profile-modal').animate({
    left: '-100%'
  },300);

  // 次動画を取得する際に最初の10件分が取得できるようにフラグをリセットする
  getNumFlg = 1;
})


// ある動画を好き登録している対象ユーザーの好き登録動画を取得する処理
function targetUserLikeMovies(id,num,delFlag) {
  $.ajax({
    type: 'get',
    url: 'http://localhost:8888/sukitsuna/moviesusers/loginuserlikemovies',
    dataType: 'json',
    data: {
      userId: id,
      dispNum: num
    }
  }).done(function(response) {
    console.log(response);

    if (response.item == undefined) {
      return;
    }

    if (delFlag === 1) {
      $('.like-login-user-like-movie').scrollTop(0);
      $('.like-login-user-like-movie-dom').text('');
    } else {
      if (response.addRecordFlg == false) {
        return;
      }
    }

    $('.like-login-user-like-movie .title span').text(response.count);
  
    response.item.forEach(function(movie) {
      if (movie.view_count != null) {
        var viewCount = movie.view_count.toLocaleString();
      } else {
        var viewCount = 0;
      }
      if (movie.like_count != null) {
        var likeCount = movie.like_count.toLocaleString();
      } else {
        var likeCount = 0;
      }
      if (movie.dislike_count != null) {
        var dislikeCount = movie.dislike_count.toLocaleString();
      } else {
        var dislikeCount = 0;
      }
      if (movie.comment_count != null) {
        var commentCount = movie.comment_count.toLocaleString();
      } else {
        var commentCount = 0;
      }

      var html = '<div class="row p-3 mb-5 profile-movie-area movie-common-area"><div class="col-7 h-100 d-flex align-items-center"><div class="h-100 d-flex align-items-center">' + movie.link + '</div></div><div class="col-5 h-100"><div class="h-75 mt-4 profile-movie-title-description"><p class="font-weight-bold border-bottom border-success">タイトル</p><p class="profile-title">' + movie.title + '</p><p class="font-weight-bold border-bottom border-success">再生数</p><p>' + viewCount +'</p><p class="font-weight-bold border-bottom border-success">高評価数</p><p>' + likeCount +'</p><p class="font-weight-bold border-bottom border-success">低評価数</p><p>' + dislikeCount +'</p><p class="font-weight-bold border-bottom border-success">コメント数</p><p>' + commentCount +'</p></div><div class="row justify-content-around">';

      if ($('.hidden-login-id').length) {
        var likeMovies = $('.hidden-login_user-like-movies').val();
        likeMovies = likeMovies.split(',');
        
        if (likeMovies.indexOf(movie.id)) {
          html += '<button class="btn p-3 like-btn unlike-btn">好き解除</button>';
        } else {
          html += '<button class="btn btn-info p-3 like-btn">好き</button>';
        }
      } else {
        html += '<button class="btn btn-info p-3 like-btn">好き</button>';
      }

      html += '<a href="/sukitsuna/moviesusers/likeUserIndex?id=' + movie.id + '" class="btn btn-warning p-3 like-index-btn">好き一覧（<span>' + movie.users + '</span>）</a><input type="hidden" class="hidden profile-hidden-id" value="' + movie.id + '"></div></div></div>';
      
      $('.like-login-user-like-movie-dom').append(html);
    })
  }).fail(function(response) {
    console.log('error');
    console.log(response);
  });
}

// プロフィールモーダル内の動画領域を最下部までスクロールした時に処理を発生
$('.like-login-user-like-movie').scroll(function() {
  $('.like-login-user-like-movie')[0].onscroll = (event) => {
    if (event.target.clientHeight + event.target.scrollTop === event.target.scrollHeight) {
      // 対象ユーザーのidを取得する
      var userId = $('.hidden-like-twitter-user-id').val();
      getNumFlg++;
      // 対象ユーザーの好き登録動画を取得・表示する関数
      targetUserLikeMovies(userId,getNumFlg,0);
    }       
  }
});

// ユーザーカードの「詳細」ボタン押下時の処理
$(document).on('click','.like-user-info',function() {
  $('.like-user-profile-modal').animate({
    left: 0
  },500);

  // ユーザーカードに含まれているユーザー情報が格納されたhiddenから値を取得する（プロフィールモーダルに渡す用）
  var userId = $(this).parent().find('.like-user-hidden-id').val();
  var profileImageUrl = $(this).parent().find('.like-user-hidden-profile-image-url').val();
  var screenName = $(this).parent().find('.like-user-hidden-screen-name').val();
  var name = $(this).parent().find('.like-user-hidden-name').val();
  var location = $(this).parent().find('.like-user-hidden-location').val();
  var description = $(this).parent().find('.like-user-hidden-description').val();
  var friendsCount = $(this).parent().find('.like-user-hidden-friends-count').val();
  var followersCount = $(this).parent().find('.like-user-hidden-followers-count').val();
  var otherUrl = $(this).parent().find('.like-user-hidden-other-url').val();

  $('.hidden-like-twitter-user-id').val(userId);
  $('.like-user-profile-image-url').attr('src',profileImageUrl);
  $('.like-user-screen-name').attr('href',screenName);
  $('.like-user-name').text(name);
  $('.like-user-location').text(location);
  $('.like-user-description').text(description);
  $('.like-user-friends-count').text(friendsCount);
  $('.like-user-friends-count').text(friendsCount);
  $('.like-user-followers-count').text(followersCount);
  $('.like-user-other-url a').text(otherUrl)
                              .attr('href',otherUrl);

  targetUserLikeMovies(userId,getNumFlg,1);
});

// プロフィールモーダルの閉じるボタン押下時の処理
$(document).on('click','.like-user-profile-modal .close',function() {
  $('.like-user-profile-modal').animate({
    left: '-100%'
  },300);

  getNumFlg = 1;
});