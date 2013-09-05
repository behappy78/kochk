jQueryFactory(document).ready(function ($) {
  $('.switch-enable').live('click', function(){
    var parent = $(this).parents('.switch');
    $('.switch-disable',parent).removeClass('selected');
    $(this).addClass('selected');
    $('.checkbox',parent).attr('checked', true);
  });

  $('.switch-disable').live('click', function(){
    var parent = $(this).parents('.switch');
    $('.switch-enable',parent).removeClass('selected');
    $(this).addClass('selected');
    $('.checkbox',parent).attr('checked', false);
  });
});
