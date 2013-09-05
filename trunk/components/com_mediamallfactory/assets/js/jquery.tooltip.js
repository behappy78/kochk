(function($){
  var timer;
  $.fn.extend({
    tooltip: function (options) {
      var defaults = {
        message: 'Default tooltip message',
        timeout: 5,
        gravity: 's',
        cssClass: ''
      };

      if (typeof options == 'string') {
        options = { message: options }
      }

      options = $.extend(defaults, options);

      var elem = $(this);

      // Remove all tips
      //$('.tipsy').remove();

      // Show current tip
      elem
        .attr('rel', 'tipsy')
        .attr('title', options.message)
        .tipsy({ trigger: 'manual', 'gravity': options.gravity, html: true, cssClass: options.cssClass })
        .tipsy('show');

      // Set timeout to remove current tip
      clearTimeout(timer);
      timer = setTimeout(function () {
        elem.tipsy('hide');
      }, options.timeout * 1000);
    }
  });

  // Remove all tips on html clicks
  $('html').click(function (event) {
    $('.tipsy').remove();
//    if ('tipsy' != $(event.target).attr('rel')) {
//      $('.tipsy').remove();
//    }
  });
})(jQueryFactory);
