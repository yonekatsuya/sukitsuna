function common(type,targetElem,userId,movieId) {
  if (type == 'like') {
    targetElem.removeClass('btn-info')
          .addClass('unlike-btn')
          .text('好き解除');
  } else {
    targetElem.addClass('btn-info')
          .removeClass('unlike-btn')
          .text('好き');
  }

  if (targetElem.parents('.profile-movie-area').length) {
    for (var i = 0;i < $('.movie-area').length;i++) {
      if ($('.movie-area').eq(i).find('input').val() == movieId) {
        if (type == 'like') {
          $('.movie-area').eq(i).find('.btn-info')
                                .removeClass('btn-info')
                                .addClass('unlike-btn')
                                .text('好き解除');
        } else {
          $('.movie-area').eq(i).find('.unlike-btn')
                              .addClass('btn-info')
                              .removeClass('unlike-btn')
                              .text('好き');
        }
        break;
      }
    }
  }

  if (targetElem.parent().find('.like-index-btn').length) {
    var indexNum = targetElem.parent().find('.like-index-btn span').text();
    indexNum = parseInt(indexNum);
    if (type == 'like') {
      indexNum++;
    } else {
      indexNum--;
    }
    targetElem.parent().find('.like-index-btn span').text(indexNum);
  }

  if (targetElem.parents('.profile-movie-area').length) {
    // プロフィールモーダルで「好き」押下時、本画面の方に「好き一覧」ボタンを持つ同じ動画が存在すれば、数値をインクリメントする。
    for (var i = 0;i < $('.movie-area .like-index-btn').length;i++) {
      if ($('.movie-area').eq(i).find('input').val() == movieId) {
        var indexNum = $('.movie-area').eq(i).find('.like-index-btn span').text();
        indexNum = parseInt(indexNum);
        if (type == 'like') {
          indexNum++;
        } else {
          indexNum--;
        }
        $('.movie-area').eq(i).find('.like-index-btn span').text(indexNum);
        break;
      }
    }
  }

  if ($('.like-user-index-title').length) {
    var userNum = $('.like-user-index-title').find('span').text();
    userNum = parseInt(userNum);
    if (type == 'like') {
      userNum++;
    } else {
      userNum--;
    }
    $('.like-user-index-title').find('span').text(userNum);
  }

  if (type == 'like') {
    var url = 'store';
  } else {
    var url = 'delete';
  }
  $.ajax({
    type: 'post',
    url: 'http://localhost:8888/sukitsuna/moviesusers/' + url,
    dataType: 'text',
    data: {
      user_id: userId,
      movie_id: movieId
    }
  }).done(function(response) {
    if (type == 'like') {
      if ($('.user-card-area').length) {
        $('.user-profile-modal')
        // 好き動画ページから好き登録を行った場合、ログインユーザーのユーザーコンポーネントを生成して「.user-card-area」要素の最後の要素として追加する。
        var html = '<div class="like-user-area p-4 mb-5"><div class="row"><div class="col-4"><img class="like-user-image mb-3" width="100%" alt="プロフィール画像" src="' + $('.user-profile-modal .twitter-profile img').attr('src') + '"></img><button class="like-user-info btn btn-info p-3 text-white font-weight-bold w-100">詳細</button><input type="hidden" class="like-user-hidden-id" value="' + userId + '"><input type="hidden" class="like-user-hidden-profile-image-url" value="' + $('.user-profile-modal .twitter-profile img').attr('src') + '"><input type="hidden" class="like-user-hidden-screen-name" value="' + $('.user-profile-modal a:first').attr('href') + '"><input type="hidden" class="like-user-hidden-name" value="' + $('.user-profile-modal .info:eq(0)').text() + '"><input type="hidden" class="like-user-hidden-location" value="' + $('.user-profile-modal .info:eq(1)').text() +'"><input type="hidden" class="like-user-hidden-description" value="' + $('.user-profile-modal .info:eq(2)').text() +'"><input type="hidden" class="like-user-hidden-friends-count" value="' + $('.user-profile-modal .info:eq(3)').text() +'"><input type="hidden" class="like-user-hidden-followers-count" value="' + $('.user-profile-modal .info:eq(4)').text() + '"><input type="hidden" class="like-user-hidden-other-url" value="' + $('.user-profile-modal .info:eq(5)').text() + '"></div><div class="col-8 like-user-area-info"><div class="font-weight-bold border-bottom border-success">名前</div><div class="name mt-2">' + $('.user-profile-modal .info:eq(0)').text() + '</div><div class="font-weight-bold border-bottom border-success mt-3">自己紹介</div><div class="introduce mt-2">' + $('.user-profile-modal .info:eq(2)').text() + '</div></div></div></div>';

        $('.user-card-area').prepend(html);
      }
    } else {
      if ($('.like-user-area').length) {
        if ($('.movie-area').find('input').val() == movieId) {
          for (var i = 0;i < $('.like-user-area').length;i++) {
            if ($('.like-user-area').eq(i).find('.like-user-hidden-id').val() == userId) {
              $('.like-user-area').eq(i).remove();
            }
          }
        }
      }
    }
  }).fail(function(response) {
    console.log('ng');
  });
}