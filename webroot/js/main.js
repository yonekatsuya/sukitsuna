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

});