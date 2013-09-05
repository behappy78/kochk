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

class MediaMallFactoryFrontendControllerMediaComment extends MediaMallFactoryFrontendControllerAdminMessage
{
  protected function prepareData($data)
  {
    $data = parent::prepareData($data);

    $media_id = JFactory::getApplication()->input->get->getInt('media_id', 0);
    $user_id  = JFactory::getUser()->id;
    $type     = 'media';

    $data['item_id'] = $media_id;
    $data['user_id'] = $user_id;
    $data['type']    = $type;

    return $data;
  }

  protected function getRedirect($data)
  {
    return FactoryRoute::view('mediacomments&media_id=' . $data['item_id']);
  }
}
