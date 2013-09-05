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

JLoader::register('MediaMallFactoryFrontendModelEdit', FactoryApplication::getInstance()->getPath('component_site').DS.'models'.DS.'edit.php');

class MediaMallFactoryBackendModelMedia extends MediaMallFactoryFrontendModelEdit
{
  public function publish($batch, $state = 1)
  {
    JArrayHelper::toInteger($batch);

    if (!$batch) {
      $this->setError(FactoryText::_('list_empty'));
      return false;
    }

    foreach ($batch as $id) {
      $item = $this->getItem($id);

      if (!$item->publish($state)) {
        $this->setError($item->getError());
        return false;
      }
    }

    return true;
  }

  public function getMessages()
  {
    $item = $this->getItem();
    $model = JModel::getInstance('AdminMessages', 'MediaMallFactoryBackendModel');

    return $model->getItems('media', $item->id);
  }

  public function getMessageForm()
  {
    $model = JModel::getInstance('AdminMessage', 'MediaMallFactoryBackendModel');

    return $model->getForm();
  }

  protected function allowEdit($table)
  {
    return true;
  }
}
