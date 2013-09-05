jQueryFactory(document).ready(function ($) {
  // Currency to Credits fields
  $('.mediamallfactorycurrencytocredits').each(function (index, element) {
    var elem   = $(element);
    var rate   = elem.attr('data-rate');
    var amount = elem.attr('data-amount');

    $('#' + amount).keyup(function (event) {
      var value = $(this).val();

      if (isNaN(value)) {
        elem.val(0);
        return true;
      }

      elem.html(parseInt(value / rate));

      return true;
    }).keyup();
  });
});
