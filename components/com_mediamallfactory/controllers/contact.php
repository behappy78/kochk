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

JLoader::register('MediaMallFactoryFrontendControllerAdminMessage', FactoryApplication::getInstance()->getPath('component_site').DS.'controllers'.DS.'adminmessage.php');

class MediaMallFactoryFrontendControllerContact extends MediaMallFactoryFrontendControllerAdminMessage
{
  protected function prepareData($data)
  {
    $data = parent::prepareData($data);

    $model = JModel::getInstance('Contacts', 'MediaMallFactoryFrontendModel');
    $purchase = $model->getPurchase();
    $media = $model->getMedia();

    $user_id  = JFactory::getUser()->id;

    $data['item_id']  = $purchase->id;
    $data['user_id']  = $user_id;
    $data['type']     = 'contact';
    $data['owner_id'] = $purchase->author_id;

    return $data;
  }

  protected function getRedirect($data)
  {
    return FactoryRoute::view('contacts&contact_id=' . $data['item_id']);
  }
}
