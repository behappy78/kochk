jQueryFactory(document).ready(function ($) {
  $('input.rating-star').prev().find('.rating-star').click(function (event) {
    var parent = $(this).parents('.rating-wrapper:first');
    var value  = parent.find('.rating-star').index(this);
    for (var i = 0; i <= value; i++) {
      parent.find('.rating-star:eq('+i+')').removeClass('star-empty').addClass('star-full');
    }

    for (var i = value + 1; i < 5; i++) {
      parent.find('.rating-star:eq('+i+')').removeClass('star-full').addClass('star-empty');
    }

    parent.next().val(value + 1);
  });
});
