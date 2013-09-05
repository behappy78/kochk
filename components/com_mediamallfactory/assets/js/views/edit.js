window.addEvent('domready', function() {
  document.formvalidator.setHandler('extension', function (value, el) {
    var split   = value.split('.');
    var ext     = split[split.length - 1];
    var allowed = el.getAttribute('extensions');

    if ('' == allowed) {
      return true;
    }

    allowed = allowed.split(',');

    for (var i = 0, count = allowed.length; i < count; i++) {
      var extension = allowed[i].trim();

      if (extension.toLowerCase() == ext.toLowerCase()) {
        return true;
      }
    }

    return false;
  });
});
