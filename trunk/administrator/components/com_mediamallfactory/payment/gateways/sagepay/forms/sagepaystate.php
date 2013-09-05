<?php

class JFormRuleSagePayState extends JFormRule
{
  public function test(&$element, $value, $group = null, &$input = null, &$form = null)
	{
    if ('US' != $input->get('country')) {
      return true;
    }

    if (0 == strlen($value)) {
      $element['message'] = FactoryText::_('sagepay_state_required');
      return false;
    }

    return true;
  }
}
