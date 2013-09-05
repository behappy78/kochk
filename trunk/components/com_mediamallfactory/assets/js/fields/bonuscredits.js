jQueryFactory(document).ready(function ($) {
  $('#purchasecredits_credits').keyup(function (event) {
    var elem   = $(this);
    var value  = parseInt(elem.val());
    var target = $('#credits_bonus');

    if (isNaN(value)) {
      target.html(0);
      return true;
    }

    var current = 0;
    for (var i = 0, count = Joomla._mediamallfactory_bonuses.length; i < count; i++) {
      var bonus = Joomla._mediamallfactory_bonuses[i];

      if (bonus.credits <= value) {
        current = bonus.bonus;
      }
    }

    target.html(current);

    return true;
  });
});
