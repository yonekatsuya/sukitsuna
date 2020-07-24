$(function() {
  $(document).on('click','.header-search',function() {
    $('.search-side').animate({
      right: '0'
    },200);
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
    // まず、検索キーワードを元に「search」APIにリクエストを送り、検索結果を指定件数分取得する
    $.ajax({
      type: 'get',
      url: 'https://www.googleapis.com/youtube/v3/search',
      dataType: 'json',
      data: {
        part: 'snippet',
        type: 'video',
        q: $('.admin-text').val(),
        maxResults: 50,
        key: 'AIzaSyDyTMF921K1ieBQeyWN8GK4VZ79DpETWR4'
      }
    }).done(function(response) {
      // 指定件数分のデータを取得出来た
      console.log(response);

      $array = [];
      for ($i = 0; $i < response.items.length;$i++) {
        $array.push(1);
      }

      dummy();

      function dummy() {
        if ($array.length === 0) {
          return
        }

        $loop_num = response.items.length - $array.length;

        // 順番に動画情報を取得する
        $videoId = response.items[$loop_num].id.videoId;
        $link = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+ $videoId +'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        $title = response.items[$loop_num].snippet.title;
        $description = response.items[$loop_num].snippet.description;
        $channelTitle = response.items[$loop_num].snippet.channelTitle;
  
        $.ajax({
          type: 'get',
          url: 'https://www.googleapis.com/youtube/v3/videos',
          dataType: 'json',
          data: {
            part: 'statistics',
            key: 'AIzaSyDyTMF921K1ieBQeyWN8GK4VZ79DpETWR4',
            id: $videoId
          }
        }).done(function(data) {
          console.log(data);
          $viewCount = data.items[0].statistics.viewCount;
          $likeCount = data.items[0].statistics.likeCount;
          $dislikeCount = data.items[0].statistics.dislikeCount;
          $commentCount = data.items[0].statistics.commentCount;
          console.log($viewCount);
  
          $.ajax({
            type: 'post',
            url: 'http://localhost:8888/sukitsuna/movies/store',
            dataType: 'text',
            data: {
              link: $link,
              title: $title,
              description: $description,
              channelTitle: $channelTitle,
              viewCount: $viewCount,
              likeCount: $likeCount,
              dislikeCount: $dislikeCount,
              commentCount: $commentCount
            }
          }).done(function(success) {
            console.log(success);
          }).fail(function(error) {
            console.log(error);
          });
        }).fail(function(data) {
          console.log(data);
        });

        $array.shift();

        setTimeout(function() {
          dummy();
        },300);

      }



    }).fail(function(response) {
      console.log(response);
    });
  });

});