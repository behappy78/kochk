jQueryFactory(document).ready(function ($) {
    $('select').each(function (index, elem) {
      var element = $(elem);

      var selected = element.find('option[selected]');
      var options  = element.find('option');
      if (!selected.length) {
        selected = element.find('option:first');
      }

      var dl = $('<dl class="dropdown" id="' + element.attr('id') + '"></dl>');
      dl.append('<dt><a href="#"><span>' + selected.text() + '</span></a></dt>');
      dl.append('<dd><ul></ul></dd>');

      options.each(function () {
        dl.find('ul:first').append('<li><a href="#" class="' + $(this).val() + '">' + $(this).text() + '</a></li>');
      });

      $(elem).hide().after(dl);
      //$(elem).after(dl);
    });

    $('.dropdown dt a').click(function(event) {
      event.preventDefault();
      $(this).parents('.dropdown:first').find('dd ul').toggle();
      //$('.dropdown dd ul').toggle();
    });

    $('.dropdown dd ul li a').click(function(event) {
      event.preventDefault();

      var text = $(this).html();
      var parent = $(this).parents('.dropdown:first');

      parent.find('dt a span').html(text);
      parent.find('dd ul').hide();

      var select = $(this).parents('dl:first').prev();
      var value  = $(this).attr('class');

      if (select.val() != value) {
        select.val(value).change();
      }

      //$('.dropdown dt a span').html(text);
      //$('.dropdown dd ul').hide();
    });

    $(document).bind('click', function(e) {
      var $clicked = $(e.target);

      if (!$clicked.parents().hasClass('dropdown')) {
        $('.dropdown dd ul').hide();
      } else {
        var id = $clicked.parents('.dropdown:first').attr('id');
        $('.dropdown[id!="'+id+'"] dd ul').hide();
      }
    });
  });
