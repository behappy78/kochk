jQueryFactory(document).ready(function ($) {
  $('.mediamallfactory-type').change(function () {
    var elem   = $(this);
    var value  = elem.val();
    var target = $('#' + elem.attr('rel'));
    var info   = target.parent().find('.mediamallfactoryfile-extensions');

    if (undefined != Joomla._mediamallfactory_extensions[value]) {
      var extensions = Joomla._mediamallfactory_extensions[value].join(', ');
      info.show().html(extensions);
      target.attr('extensions', extensions);
    } else {
      info.hide();
    }
  }).change();
});
