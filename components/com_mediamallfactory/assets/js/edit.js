Joomla.submitbutton = function(pressbutton) {
  if (-1 === pressbutton.indexOf('.cancel') && !document.formvalidator.isValid(document.id('adminForm'))) {
    alert(Joomla.JText._('JGLOBAL_VALIDATION_FORM_FAILED'));
    return false;
  }

  Joomla.submitform(pressbutton);

  return true;
}

window.addEvent('domready', function() {
  document.formvalidator.validate = function(el) {
    el = document.id(el);

    // Ignore the element if its currently disabled, because are not submitted for the http-request. For those case return always true.
    if(el.get('disabled')) {
      this.handleResponse(true, el);
      return true;
    }

    // If the field is required make sure it has a value
    if (el.hasClass('required')) {
      if (el.get('tag')=='fieldset' && (el.hasClass('radio') || el.hasClass('checkboxes'))) {
        for(var i=0;;i++) {
          if (document.id(el.get('id')+i)) {
            if (document.id(el.get('id')+i).checked) {
              break;
            }
          }
          else {
            this.handleResponse(false, el);
            return false;
          }
        }
      }
      else if (!(el.get('value'))) {
        this.handleResponse(false, el);
        return false;
      }
    }

    // Only validate the field if the validate class is set
    var handler = (el.className && el.className.search(/validate-([a-zA-Z0-9\_\-]+)/) != -1) ? el.className.match(/validate-([a-zA-Z0-9\_\-]+)/)[1] : "";
    if (handler == '') {
      this.handleResponse(true, el);
      return true;
    }

    // Check the additional validation types
    if ((handler) && (handler != 'none') && (this.handlers[handler]) && el.get('value')) {
      // Execute the validation handler and return result
      if (this.handlers[handler].exec(el.get('value'), el) != true) {
        this.handleResponse(false, el);
        return false;
      }
    }

    // Return validation state
    this.handleResponse(true, el);
    return true;
  }
});
