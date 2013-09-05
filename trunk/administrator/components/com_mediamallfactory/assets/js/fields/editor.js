jQueryFactory(document).ready(function ($) {
  $('.mediamallfactoryeditor-token').click(function (event) {
    event.preventDefault();

    var elem   = $(this);
    var editor = elem.parents('table:first').attr('rel');
    var text   = elem.text();
    jInsertEditorText(text, editor);
  })
});
