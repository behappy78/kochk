jQueryFactory(document).ready(function ($) {
  // Show review form
  $('.show-review-form').click(function (event) {
    event.preventDefault();

    $(this).hide();
    $('.comment-form').slideDown();
  });

  // Hide review form
  $('.hide-review-form').click(function (event) {
    event.preventDefault();

    $('.comment-form').slideUp(function () {
      $('.show-review-form').show();
    });
  });
});
