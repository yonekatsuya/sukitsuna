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
});