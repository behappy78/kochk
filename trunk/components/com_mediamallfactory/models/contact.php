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

JLoader::register('MediaMallFactoryFrontendModelAdminMessage', FactoryApplication::getInstance()->getPath('component_site').DS.'models'.DS.'adminmessage.php');

class MediaMallFactoryFrontendModelContact extends MediaMallFactoryFrontendModelAdminMessage
{
  protected function allowSave($data)
  {
    return true;
  }

  protected function prepareData(&$data)
  {
    $data = parent::prepareData($data);

    $model = JModel::getInstance('Contacts', 'MediaMallFactoryFrontendModel');
    $media = $model->getMedia();

    $data['is_admin'] = (integer)$media->isOwner();

    return $data;
  }
}
