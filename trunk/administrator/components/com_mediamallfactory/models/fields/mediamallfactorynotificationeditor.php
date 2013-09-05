<?php

/**------------------------------------------------------------------------
com_mediamallfactory - Media Mall Factory 3.3.5 
------------------------------------------------------------------------
 * @author TheFactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thefactory.ro
 * Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

JFormHelper::loadFieldType('MediaMallFactoryInvoiceTemplateEditor');

class JFormFieldMediaMallFactoryNotificationEditor extends JFormFieldMediaMallFactoryInvoiceTemplateEditor
{
  public $type = 'MediaMallFactoryNotificationEditor';

  protected function getOptions()
  {
    $options = array();
    $type    = $this->form->getValue('type');
    $xml     = JFactory::getXML(FactoryApplication::getInstance()->getPath('component_administrator').DS.'notifications.xml');
    $notification = $xml->xpath('//notification[@type="' . $type . '"]');

    if (!$notification) {
      return $options;
    }

    foreach ($notification[0]->option as $option) {
      $options['%%'.(string)$option.'%%'] = 'notification_'.$type.'_'.$option;
    }

    return $options;
  }
}
