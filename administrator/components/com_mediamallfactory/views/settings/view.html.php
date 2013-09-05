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

class MediaMallFactoryBackendViewSettings extends FactoryView
{
  protected
    $get       = array('form', 'config', 'option'),
    $buttons   = array('apply', 'save', 'close'),
    $behaviors = array('tooltip', 'formvalidation'),
    $css = array('edit', 'views/edit', 'admin/edit', 'admin/adminmessages', 'buttons')
  ;

  protected function setTitle()
  {
    $form = JFactory::getApplication()->input->getCmd('form', 'config');

    if ('config' == $form) {
      return parent::setTitle();
    }

    JToolBarHelper::title(FactoryText::_('view_title_settings_' . $form));

    return true;
  }
}
