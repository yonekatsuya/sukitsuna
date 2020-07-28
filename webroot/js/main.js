$(function() {
  $(document).on('click','.header-search',function() {
    if ($('.search-side').css('right') === '0px') {
      $('.search-side').animate({
        right: '-30%'
      },500);
    } else {
      $('.search-side').animate({
        right: '0'
      },200);
    }
  });

  $(document).on('click','.search-side-content .close',function() {
    $('.search-side').animate({
      right: '-30%'
    },500);
  });

  $(document).one('click','#sakamitiButton',function() {
    $(this).trigger('click');
  });

  $(document).one('click','#wackButton',function() {
    $(this).trigger('click');
  });

  // トップスクロールボタン関連の処理
  $('.scroll-btn').css('opacity',0);
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.scroll-btn').css('opacity',1);
    } else {
      $('.scroll-btn').css('opacity',0);
    }
  });

  $(document).on('click','.scroll-btn',function() {
    $('body,html').animate({
      scrollTop: 0
    },500);
  });


  // 管理者画面の入力フォームに検索キーワードを挿入し、送信ボタンを押した時の処理
  $(document).on('click','.admin-btn',function() {
    var nextPageToken = '';
    var loop_num_flag = 1;

    top('first');

    function top(num_flag) {
      if (loop_num_flag == 0) {
        return;
      }

      if (num_flag === 'first') {
        var searchRequestData = {
          part: 'snippet',
          type: 'video',
          maxResults: 50,
          key: 'AIzaSyD9RjianGovG_qM4lIQ6D8EByzF7sg6Ldw',
          q: $('.admin-text').val(),
        }
      } else {
        var searchRequestData = {
          part: 'snippet',
          type: 'video',
          maxResults: 50,
          key: 'AIzaSyD9RjianGovG_qM4lIQ6D8EByzF7sg6Ldw',
          q: $('.admin-text').val(),
          pageToken: nextPageToken
        }
      }

      // まず、検索キーワードを元に「search」APIにリクエストを送り、検索結果を指定件数分取得する
      $.ajax({
        type: 'get',
        url: 'https://www.googleapis.com/youtube/v3/search',
        dataType: 'json',
        data: searchRequestData
      }).done(function(response) {
        // 指定件数分のデータを取得出来た
        console.log(response);
        nextPageToken = response.nextPageToken;
  
        var array = [];
        for (var i = 0; i < response.items.length;i++) {
          array.push(1);
        }
  
        dummy();
  
        function dummy() {
          // 50回目の処理が終わったタイミングで、関数内の処理を終了する
          if (array.length === 0) {
            loop_num_flag--;
            top('second');
            return;
          }
  
          var loop_num = response.items.length - array.length;
  
          // 順番に動画情報を取得する
          var videoId = response.items[loop_num].id.videoId;
          var link = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+ videoId +'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
          var title = response.items[loop_num].snippet.title;
          var description = response.items[loop_num].snippet.description;
          var channelTitle = response.items[loop_num].snippet.channelTitle;
    
          $.ajax({
            type: 'get',
            url: 'https://www.googleapis.com/youtube/v3/videos',
            dataType: 'json',
            data: {
              part: 'statistics',
              key: 'AIzaSyD9RjianGovG_qM4lIQ6D8EByzF7sg6Ldw',
              id: videoId
            }
          }).done(function(data) {
            console.log(data);
            var viewCount = data.items[0].statistics.viewCount;
            var likeCount = data.items[0].statistics.likeCount;
            var dislikeCount = data.items[0].statistics.dislikeCount;
            var commentCount = data.items[0].statistics.commentCount;
            var groupName = $('.admin-text').val();
            console.log(viewCount);
    
            $.ajax({
              type: 'post',
              url: 'http://localhost:8888/sukitsuna/movies/store',
              dataType: 'text',
              data: {
                link: link,
                title: title,
                description: description,
                channelTitle: channelTitle,
                viewCount: viewCount,
                likeCount: likeCount,
                dislikeCount: dislikeCount,
                commentCount: commentCount,
                groupName: groupName
              }
            }).done(function(success) {
              console.log(success);
            }).fail(function(error) {
              console.log(error);
            });
          }).fail(function(data) {
            console.log(data);
          });
  
          array.shift();
  
          setTimeout(function() {
            dummy();
          },300);
  
        }
  
      }).fail(function(response) {
        console.log(response);
      });

    }


  });



  // トップページのページネーションのデザイン指定（Bootstrap）
  $('.paging-flag li').addClass('page-item');
  $('.paging-flag li a').addClass('page-link');


  $(document).on('click','.movie-delete',function() {
    var id = $(this).parent().find('.hidden').val();
    $('.movie-delete-hidden').val(id);
  });



  // サイドモーダルが開いている時に、画面上のどこかしらを押下するとサイドモーダルが閉じる処理
  $(document).on('click',function(e) {
    if ($('.search-side').css('right') === '0px') {
      if ($(e.target).closest('.header-search').length) {
        return;
      } else if (!$(e.target).closest('.search-side').length) {
        $('.search-side').animate({
          right: '-30%'
        },500);
      }
    }
  });


  // ヘッダーの「登録/ログイン」ボタン押下時にモーダルを表示する
  $(document).on('click','.header-register-login',function() {
    $('.register-login-modal').animate({
      top: 0
    },300);
    $('.register-login-modal-content').animate({
      top: '50%'
    },300);
  });

  $(document).on('click','.register-login-modal-content .close',function() {
    $('.register-login-modal').animate({
      top: '-100%'
    },300);
    $('.register-login-modal-content').animate({
      top: '-50%'
    },300);
  });

  // ヘッダーのプロフィール画像押下時の処理（2回連続のクリックイベント）
  $(document).one('click','.header-profile',function() {
    $(this).trigger('click');
  });

  // ヘッダーの「プロフィール」押下時の処理
  $(document).on('click','.header-profile-btn',function() {
    $('.user-profile-modal').animate({
      left: 0
    },500);

    var userId = $('.hidden-login-id').val();

    $.ajax({
      type: 'get',
      url: 'http://localhost:8888/sukitsuna/moviesusers/loginuserlikemovies',
      dataType: 'json',
      data: {
        userId: userId
      }
    }).done(function(response) {
      $('.login-user-like-movie .title span').text(response.count);

      $('.login-user-like-movie-dom').text('');

      response.item.forEach(function(movie) {
        var html = '<div class="row p-3 mb-5 profile-movie-area movie-common-area"><div class="col-7 h-100 d-flex align-items-center"><div class="h-100 d-flex align-items-center">' + movie.link + '</div></div><div class="col-5 h-100"><div class="h-75 mt-4 profile-movie-title-description"><p class="font-weight-bold border-bottom border-success">タイトル</p><p class="profile-title">' + movie.title + '</p><p class="font-weight-bold border-bottom border-success">再生数</p><p>' + movie.view_count +'</p><p class="font-weight-bold border-bottom border-success">高評価数</p><p>' + movie.like_count +'</p><p class="font-weight-bold border-bottom border-success">低評価数</p><p>' + movie.dislike_count +'</p><p class="font-weight-bold border-bottom border-success">コメント数</p><p>' + movie.comment_count +'</p></div><div class="row justify-content-around">';

        var likeMovies = $('.hidden-login_user-like-movies').val();
        likeMovies = likeMovies.split(',');
        
        if (likeMovies.indexOf(movie.id)) {
          html += '<button class="btn p-3 like-btn unlike-btn">好き解除</button>';
        } else {
          html += '<button class="btn btn-info p-3 like-btn">好き</button>';
        }

        html += '<a href="/sukitsuna/moviesusers/likeUserIndex?id=' + movie.id + '" class="btn btn-warning p-3 like-index-btn">好き一覧（<span>' + movie.users + '</span>）</a><input type="hidden" class="hidden profile-hidden-id" value="' + movie.id + '"></div></div></div>';
        
        $('.login-user-like-movie-dom').append(html);
      })

    }).fail(function(response) {
      console.log('error');
      console.log(response);
    });
  });

  // ログインプロフィールモーダルの閉じるボタン押下時の処理
  $(document).on('click','.user-profile-modal .close',function() {
    $('.user-profile-modal').animate({
      left: '-100%'
    },300);
  })


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

    $.ajax({
      type: 'get',
      url: 'http://localhost:8888/sukitsuna/moviesusers/loginuserlikemovies',
      dataType: 'json',
      data: {
        userId: userId
      }
    }).done(function(response) {
      console.log(response);

      $('.like-login-user-like-movie .title span').text(response.count);

      $('.like-login-user-like-movie-dom').text('');

      response.item.forEach(function(movie) {
        var html = '<div class="row p-3 mb-5 profile-movie-area movie-common-area"><div class="col-7 h-100 d-flex align-items-center"><div class="h-100 d-flex align-items-center">' + movie.link + '</div></div><div class="col-5 h-100"><div class="h-75 mt-4 profile-movie-title-description"><p class="font-weight-bold border-bottom border-success">タイトル</p><p class="profile-title">' + movie.title + '</p><p class="font-weight-bold border-bottom border-success">再生数</p><p>' + movie.view_count +'</p><p class="font-weight-bold border-bottom border-success">高評価数</p><p>' + movie.like_count +'</p><p class="font-weight-bold border-bottom border-success">低評価数</p><p>' + movie.dislike_count +'</p><p class="font-weight-bold border-bottom border-success">コメント数</p><p>' + movie.comment_count +'</p></div><div class="row justify-content-around">';

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
    });
  });

  // プロフィールモーダルの閉じるボタン押下時の処理
  $(document).on('click','.like-user-profile-modal .close',function() {
    $('.like-user-profile-modal').animate({
      left: '-100%'
    },300);
  })


  // 動画の「好き」ボタン押下時の処理（ログイン時のみ処理を走らせる）
  $(document).on('click','.movie-area .like-btn, .profile-movie-area .like-btn',function() {
    // 押下した対象要素を取得する
    var clickElement = $(this);

    // ログインしていなければ、処理を中断する
    if (!$('.hidden-login-id').length) {
      var url = encodeURIComponent(location.href);
      location.href = 'http://localhost:8888/sukitsuna/moviesusers/store?query=' + url;
      return;
    }

    // ログインユーザーのID値と対象動画のIDを取得する
    var userId = $('.hidden-login-id').val();
    var movieId = $(this).parent().find('input').val();


    // 「好き」ボタン押下時の処理
    if ($(this).hasClass('btn-info')) {
      // 対象ボタンの表示切り替え
      $(this).removeClass('btn-info')
             .addClass('unlike-btn')
             .text('好き解除');

      // プロフィールモーダル上で「好き」ボタンを押下した場合、本画面に対象動画が存在していれば、ボタンの表示を切り替える。
      if (clickElement.parents('.profile-movie-area').length) {
        for (var i = 0;i < $('.movie-area').length;i++) {
          if ($('.movie-area').eq(i).find('input').val() == movieId) {
            $('.movie-area').eq(i).find('.btn-info')
                                  .removeClass('btn-info')
                                  .addClass('unlike-btn')
                                  .text('好き解除');
            break;
          }
        }
      }

      // プロフィールモーダルもしくはトップ画面の動画一覧で「好き」を押下した際、横の「好き一覧」ボタンのカッコ内の数値をインクリメントする。
      if ($(this).parent().find('.like-index-btn').length) {
        var indexNum = $(this).parent().find('.like-index-btn span').text();
        indexNum = parseInt(indexNum);
        indexNum++;
        $(this).parent().find('.like-index-btn span').text(indexNum);
      }

      // プロフィールモーダルの「好き」押下時のみ実行
      if (clickElement.parents('.profile-movie-area').length) {
        // プロフィールモーダルで「好き」押下時、本画面の方に「好き一覧」ボタンを持つ同じ動画が存在すれば、数値をインクリメントする。
        for (var i = 0;i < $('.movie-area .like-index-btn').length;i++) {
          if ($('.movie-area').eq(i).find('input').val() == movieId) {
            var indexNum = $('.movie-area').eq(i).find('.like-index-btn span').text();
            indexNum = parseInt(indexNum);
            indexNum++;
            $('.movie-area').eq(i).find('.like-index-btn span').text(indexNum);
            break;
          }
        }
      }

      if ($('.like-user-index-title').length) {
        var userNum = $('.like-user-index-title').find('span').text();
        userNum = parseInt(userNum);
        userNum++;
        $('.like-user-index-title').find('span').text(userNum);
      }

      $.ajax({
        type: 'post',
        url: 'http://localhost:8888/sukitsuna/moviesusers/store',
        dataType: 'text',
        data: {
          userId: userId,
          movieId: movieId
        }
      }).done(function(response) {
        console.log('ok');

        if ($('.user-card-area').length) {
          $('.user-profile-modal')
          // 好き動画ページから好き登録を行った場合、ログインユーザーのユーザーコンポーネントを生成して「.user-card-area」要素の最後の要素として追加する。
          var html = '<div class="like-user-area p-4 mb-5"><div class="row"><div class="col-4"><img class="like-user-image mb-3" width="100%" alt="プロフィール画像" src="' + $('.user-profile-modal .twitter-profile img').attr('src') + '"></img><button class="like-user-info btn btn-info p-3 text-white font-weight-bold w-100">詳細</button><input type="hidden" class="like-user-hidden-id" value="' + userId + '"><input type="hidden" class="like-user-hidden-profile-image-url" value="' + $('.user-profile-modal .twitter-profile img').attr('src') + '"><input type="hidden" class="like-user-hidden-screen-name" value="' + $('.user-profile-modal a:first').attr('href') + '"><input type="hidden" class="like-user-hidden-name" value="' + $('.user-profile-modal .info:eq(0)').text() + '"><input type="hidden" class="like-user-hidden-location" value="' + $('.user-profile-modal .info:eq(1)').text() +'"><input type="hidden" class="like-user-hidden-description" value="' + $('.user-profile-modal .info:eq(2)').text() +'"><input type="hidden" class="like-user-hidden-friends-count" value="' + $('.user-profile-modal .info:eq(3)').text() +'"><input type="hidden" class="like-user-hidden-followers-count" value="' + $('.user-profile-modal .info:eq(4)').text() + '"><input type="hidden" class="like-user-hidden-other-url" value="' + $('.user-profile-modal .info:eq(5)').text() + '"></div><div class="col-8 like-user-area-info"><div class="font-weight-bold border-bottom border-success">名前</div><div class="name mt-2">' + $('.user-profile-modal .info:eq(0)').text() + '</div><div class="font-weight-bold border-bottom border-success mt-3">自己紹介</div><div class="introduce mt-2">' + $('.user-profile-modal .info:eq(2)').text() + '</div></div></div></div>';

          $('.user-card-area').prepend(html);
        }
      }).fail(function(response) {
        console.log('ng');
      });

      // 「好き解除」ボタン押下時の処理
    } else {
      // 対象ボタンの表示切り替え
      $(this).addClass('btn-info')
             .removeClass('unlike-btn')
             .text('好き');

      // プロフィールモーダル上で「好き解除」ボタンを押下した場合、本画面に対象動画存在していれば、ボタンの表示を切り替える。
      if (clickElement.parents('.profile-movie-area').length) {
        for (var i = 0;i < $('.movie-area').length;i++) {
          if ($('.movie-area').eq(i).find('input').val() == movieId) {
            $('.movie-area').eq(i).find('.unlike-btn')
                                  .addClass('btn-info')
                                  .removeClass('unlike-btn')
                                  .text('好き');
            break;
          }
        }
      }

      // プロフィールモーダルもしくはトップ画面の動画一覧で「好き解除」を押下した際、横の「好き一覧」ボタンのカッコ内の数値をデクリメントする。
      if ($(this).parent().find('.like-index-btn').length) {
        var indexNum = $(this).parent().find('.like-index-btn span').text();
        indexNum = parseInt(indexNum);
        indexNum--;
        $(this).parent().find('.like-index-btn span').text(indexNum);
      }

      // プロフィールモーダルの「好き解除」押下時のみ実行（本画面の「好き解除」では実行されない）
      if (clickElement.parents('.profile-movie-area').length) {
        // プロフィールモーダルで「好き解除」押下時、本画面の方に「好き一覧」ボタンを持つ同じ動画が存在すれば、数値をデクリメントする。
        for (var i = 0;i < $('.movie-area .like-index-btn').length;i++) {
          if ($('.movie-area').eq(i).find('input').val() == movieId) {
            var indexNum = $('.movie-area').eq(i).find('.like-index-btn span').text();
            indexNum = parseInt(indexNum);
            indexNum--;
            $('.movie-area').eq(i).find('.like-index-btn span').text(indexNum);
            break;
          }
        }
      }

      if ($('.like-user-index-title').length) {
        var userNum = $('.like-user-index-title').find('span').text();
        userNum = parseInt(userNum);
        userNum--;
        $('.like-user-index-title').find('span').text(userNum);
      }
      
      $.ajax({
        type: 'post',
        url: 'http://localhost:8888/sukitsuna/moviesusers/delete',
        dataType: 'text',
        data: {
          userId: userId,
          movieId: movieId
        }
      }).done(function(response) {
        // プロフィールモーダルもしくは本画面で「好き解除」ボタン押下時、ユーザーカードが表示されているページでは、対象ユーザーのカードを削除する
        if ($('.like-user-area').length) {
          if ($('.movie-area').find('input').val() == movieId) {
            for (var i = 0;i < $('.like-user-area').length;i++) {
              if ($('.like-user-area').eq(i).find('.like-user-hidden-id').val() == userId) {
                $('.like-user-area').eq(i).remove();
              }
            }
          }
        }
      }).fail(function(response) {
        console.log('ng');
      });
    }

  });

});