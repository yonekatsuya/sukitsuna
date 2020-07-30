$(function() {

  // ヘッダーの「検索」ボタン押下時の処理
  $(document).on('click','.header-search',function() {
    // 検索サイドモーダルが表示されていれば、画面右外に隠す
    if ($('.search-side').css('right') === '0px') {
      $('.search-side').animate({
        right: '-30%'
      },500);
    } else {
      // 検索サイドモーダルが表示されていなければ、画面右外から画面上に表示する
      $('.search-side').animate({
        right: '0'
      },200);
    }
  });

  // 検索サイドモーダルの「×」ボタン押下時の処理
  $(document).on('click','.search-side-content .close',function() {
    // 画面右外に検索サイドモーダルを隠す
    $('.search-side').animate({
      right: '-30%'
    },500);
  });

  // Bootstrapでプルダウンメニューを作成したが最初二回押さないとメニューが表示されないため、最初だけダブルクリックになるようにする
  $(document).one('click','#sakamitiButton',function() {
    $(this).trigger('click');
  });
  $(document).one('click','#wackButton',function() {
    $(this).trigger('click');
  });
  $(document).one('click','.header-profile',function() {
    $(this).trigger('click');
  });

  // 画面スクロール時の処理
  $('.scroll-btn').css('opacity',0);
  $(window).scroll(function() {
    // スクロール位置がトップから100px以上の時、、トップスクロールボタン表示
    if ($(this).scrollTop() > 100) {
      $('.scroll-btn').css('opacity',1);
    } else {
      $('.scroll-btn').css('opacity',0);
    }
  });

  // トップスクロールボタン押下時、スクロール位置を画面最上部にする
  $(document).on('click','.scroll-btn',function() {
    $('body,html').animate({
      scrollTop: 0
    },500);
  });

  // トップページのページネーションのデザイン指定（Bootstrap）
  $('.paging-flag li').addClass('page-item');
  $('.paging-flag li a').addClass('page-link');


  // 動画の「削除」ボタン押下時の処理
  $(document).on('click','.movie-delete',function() {
    // 動画IDを、表示するモーダル内に格納する（その動画IDを指定アクションに渡すことで動画を削除する）
    var id = $(this).parent().find('.hidden').val();
    $('.movie-delete-hidden').val(id);
  });

  // サイドモーダルが開いている時に、画面上のどこかしらを押下するとサイドモーダルが閉じる処理
  $(document).on('click',function(e) {
    if ($('.search-side').css('right') === '0px') {
      // ヘッダーの「検索」ボタン押下時は何もしない
      if ($(e.target).closest('.header-search').length) {
        return;
      } else if (!$(e.target).closest('.search-side').length) {
        // 画面右外に検索サイドモーダルを隠す
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

  // 「登録/ログイン」モーダルの「×」ボタン押下時にモーダルを画面上部に隠す
  $(document).on('click','.register-login-modal-content .close',function() {
    $('.register-login-modal').animate({
      top: '-100%'
    },300);
    $('.register-login-modal-content').animate({
      top: '-50%'
    },300);
  });

  // 動画の「好き」「好き解除」ボタン押下時の処理
  $(document).on('click','.movie-area .like-btn, .profile-movie-area .like-btn',function() {
    // ログインしていなければ、処理を中断する
    if (!$('.hidden-login-id').length) {
      location.href = 'http://localhost:8888/sukitsuna/moviesusers/store';
      return;
    }

    // ログインユーザーのID値と対象動画のIDを取得する
    var userId = $('.hidden-login-id').val();
    var movieId = $(this).parent().find('input').val();

    // 「好き」ボタン押下時の処理
    if ($(this).hasClass('btn-info')) {
      common('like',$(this),userId,movieId);
      // 「好き解除」ボタン押下時の処理
    } else {
      common('dislike',$(this),userId,movieId);
    }
  });

  // YouTube Data APIの処理
  // 管理者画面で入力フォームにキーワードを入力して送信ボタン押下時に実行
  $(document).on('click','.admin-btn',function() {
    // 入力フォームが空であれば、処理中断
    if ($('.admin-text').val() == '') {
      return;
    }

    // 次の何件かを取得するためのリクエストパラメータとなる情報
    var nextPageToken = '';
    // 動画データを取得してDBに保存する処理セットのループ回数
    var loop_num_flag = 1;

    // 1回目のAPIへのリクエスト処理
    youtubeAPIRequest('first',nextPageToken,loop_num_flag);
  });

});