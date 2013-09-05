jQueryFactory(document).ready(function ($) {
  // Toggle help label on mouse over
  $('.view-comments-comment').hover(function (event) {
    $(this).find('.label-help').show();
  }, function (event) {
    $(this).find('.label-help').hide();
  });

  // Help rating
  $('.help-button').click(function (event) {
    event.preventDefault();

    var elem       = $(this);
    var parent     = elem.parents('.comment-help:first');
    var comment_id = elem.parents('.view-comments-comment:first').attr('id').replace('comment-', '');
    var vote       = elem.hasClass('button-thumb-up') ? 1 : -1;
    var className  = vote == 1 ? 'button-thumb-up' : 'button-thumb';

    elem.toggleClass(className + ' button-loader');

    $.post('index.php?option=com_mediamallfactory&task=comment.vote', {
      comment_id: comment_id,
      vote: vote
    }, function (response) {
      var cssClass = '';
      elem.toggleClass(className + ' button-loader');

      if (0 == response.status) {
        response.message += ' ' + response.error;
        cssClass = 'tip-error';
      } else {
        parent.find('.button-thumb-up').text(response.votes_up);
        parent.find('.button-thumb').text(response.votes_down);
      }

      elem.tooltip({ message: response.message, cssClass: cssClass });
    }, 'json');
  });
});
