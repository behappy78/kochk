jQueryFactory(document).ready(function ($) {
  // Submit form on filter change
  $('.form_filter').change(function (event) {
    var form = $(this).parents('form:first');

    form.submit();
  });

  // Remove empty filters from form when submitting
  $('#adminForm').submit(function (event) {
    $(this).find(':input[value=""]').attr('name', '');

    return true;
  });

  // Check all checkbox
  $('.factory-view-list table th input[type="checkbox"]').click(function (event) {
    var elem = $(this);
    var checked = elem.is(':checked');

    elem.parents('table:first').find('td input[type="checkbox"]').attr('checked', checked);
  });
});

Joomla.submitbutton = function(pressbutton, list) {
  // Check if there are any items selected.
  if (list && !$$('.factory-view-list td input[type="checkbox"]:checked').length) {
    alert(Joomla.JText._('COM_MEDIAMALLFACTORY_LIST_BATCH_SELECT_ITEM'));
    return false;
  }

  Joomla.submitform(pressbutton);
}
