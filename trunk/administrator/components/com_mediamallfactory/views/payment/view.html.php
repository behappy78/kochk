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

class MediaMallFactoryBackendViewPayment extends FactoryView
{
  protected
    $buttons = array('apply', 'save', 'close'),
    $get = array('state', 'item', 'form'),
    $css = array('edit', 'views/edit', 'admin/edit'),
    $behaviors = array('tooltip', 'formvalidation')
  ;

  protected function addToolbar()
  {
    if (in_array($this->item->status, array(20, 30))) {
      unset($this->buttons[0], $this->buttons[1]);
    }

    return parent::addToolbar();
  }

  protected function setTitle()
  {
    JToolBarHelper::title(FactoryText::sprintf('view_title_payment', $this->item->refnumber, $this->item->id));

    return true;
  }
}
