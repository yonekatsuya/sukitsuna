function youtubeAPIRequest(num_flag,nextPageToken,loop_num_flag) {
  // ループ回数に達した場合、APIへのリクエストを止める
  if (loop_num_flag == 0) {
    return;
  }

  // 2回目以降のリクエストで、次の何件かの動画データを取得するために「pageToken」をパラメータにセットする
  if (num_flag === 'first') {
    var searchRequestData = {
      part: 'snippet',
      type: 'video',
      maxResults: 50,
      key: 'AIzaSyCL1esPiYUHsnExLexUjtsQ4-SAKiEKmEI',
      q: $('.admin-text').val(),
    }
  } else {
    var searchRequestData = {
      part: 'snippet',
      type: 'video',
      maxResults: 50,
      key: 'AIzaSyCL1esPiYUHsnExLexUjtsQ4-SAKiEKmEI',
      q: $('.admin-text').val(),
      pageToken: nextPageToken
    }
  }

  // 入力キーワードを元に「search」APIにリクエストを送り、動画を指定件数分取得する
  $.ajax({
    type: 'get',
    url: 'https://www.googleapis.com/youtube/v3/search',
    dataType: 'json',
    data: searchRequestData
  }).done(function(response) {
    console.log(response);
    // 2回目以降の動画データ取得処理のためにページトークンの値をセット
    nextPageToken = response.nextPageToken;

    // 動画の取得件数分だけ値を配列に格納する
    var array = [];
    for (var i = 0; i < response.items.length;i++) {
      array.push(1);
    }

    // 「videos」APIへのリクエストとmoviesテーブルへの保存処理
    movieGetAndStore();

    function movieGetAndStore() {
      // 最後の処理が終わったら、この関数内の処理を終了する
      if (array.length === 0) {
        loop_num_flag--;
        // 「loop_num_flag」の値が「0」でyoutubeAPIRequest関数を実行すると、即処理が中断する。これで、APIへのリクエストは終了する
        youtubeAPIRequest('second',nextPageToken,loop_num_flag);
        return;
      }

      // 「search」APIから取得した動画の中で、何番目の動画データを取得するか指定
      var getMovieNum = response.items.length - array.length;

      // 順番に動画情報を取得する
      // まず、「search」APIから取得した情報を変数に格納しておく
      var videoId = response.items[getMovieNum].id.videoId;
      var link = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+ videoId +'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
      var title = response.items[getMovieNum].snippet.title;
      var description = response.items[getMovieNum].snippet.description;
      var channelTitle = response.items[getMovieNum].snippet.channelTitle;

      // 対象動画の詳細情報を取得するために「videos」APIにリクエストを出す
      $.ajax({
        type: 'get',
        url: 'https://www.googleapis.com/youtube/v3/videos',
        dataType: 'json',
        data: {
          part: 'statistics',
          key: 'AIzaSyCL1esPiYUHsnExLexUjtsQ4-SAKiEKmEI',
          id: videoId
        }
      }).done(function(data) {
        var viewCount = data.items[0].statistics.viewCount;
        var likeCount = data.items[0].statistics.likeCount;
        var dislikeCount = data.items[0].statistics.dislikeCount;
        var commentCount = data.items[0].statistics.commentCount;
        var groupName = $('.admin-text').val();

        // 「search」と「videos」へのAPIアクセスにより取得した動画詳細データをmoviesテーブルに保存する
        $.ajax({
          type: 'post',
          url: 'http://localhost:8888/sukitsuna/movies/store',
          dataType: 'text',
          data: {
            link: link,
            title: title,
            description: description,
            channel_title: channelTitle,
            view_count: viewCount,
            like_count: likeCount,
            dislike_count: dislikeCount,
            comment_count: commentCount,
            group_name: groupName
          }
        }).done(function(success) {
          console.log('ok');
        }).fail(function(error) {
          console.log(error);
        });
      }).fail(function(data) {
        console.log(data);
      });

      // 残りのループ回数を判断するためのフラグ。配列から一つ要素を削除する
      array.shift();

      // 「videos」APIへのリクエストとアクションでの対象データ保存処理について、少し間を空けることで正常に動画保存できるようにする
      setTimeout(function() {
        movieGetAndStore();
      },300);
    }
  }).fail(function(response) {
    console.log(response);
  });
}