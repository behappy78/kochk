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

jimport('joomla.application.component.model');

class MediaMallFactoryFrontendModelPlayer extends JModel
{
  public function getItem()
  {
    static $items = array();
    $id = JFactory::getApplication()->input->get->getInt('media_id', 0);

    if (!isset($items[$id])) {
      $table = FactoryTable::getInstance('Media');
      $table->load($id);

      if (!$table->isAllowedToView('media')) {
        throw new Exception(FactoryText::sprintf('player_error_not_allowed', $id), 403);
        return false;
      }

      $items[$id] = $table;
    }

    return $items[$id];
  }

  public function getPlayer()
  {
    JLoader::register('MediaMallFactoryPlayer', FactoryApplication::getInstance()->getPath('players').DS.'player.php');

    $item = $this->getItem();

    $table = JTable::getInstance('Type', 'MediaMallFactoryTable');
    $table->load($item->type_id);

    $player = MediaMallFactoryPlayer::getInstance($table->player);
    $player->setSource(FactoryRoute::task('media.download&media_id='.$item->id, true, -1));
    $player->setMedia($item);

    return $player;
  }
}
