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

JLoader::register(
  'MediaMallFactoryBackendModelInvoice',
  FactoryApplication::getInstance()->getPath('component_administrator').DS.'models'.DS.'invoice.php'
);

class MediaMallFactoryFrontendModelInvoice extends MediaMallFactoryBackendModelInvoice
{
  public function getItem($pk = null)
  {
    $item = parent::getItem($pk);
    $user = JFactory::getUser();

    if (!$item || $item->user_id != $user->id) {
      throw new Exception(FactoryText::_('invoice_not_found'), 404);
    }

    return $item;
  }
}
