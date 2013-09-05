jQueryFactory(document).ready(function ($) {
  // Credits to Currency
  $('.mediamallfactorycreditstocurrency').each(function (index, element) {
    var elem    = $(element);
    var rate    = elem.attr('data-rate');
    var credits = elem.attr('data-credits');

    $('#' + credits).keyup(function (event) {
      var value = $(this).val();

      if (isNaN(value)) {
        elem.val(0);
        return true;
      }

      elem.html(parseFloat(value * rate));

      return true;
    }).keyup();
  });
});
