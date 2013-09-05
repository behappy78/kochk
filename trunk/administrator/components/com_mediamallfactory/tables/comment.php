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

class MediaMallFactoryTableComment extends FactoryTable
{
  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_comments', 'id', $db);
  }

  public function check()
  {
    if (!parent::check()) {
      return false;
    }

    if (!$this->user_id) {
      $this->user_id = JFactory::getUser()->id;
    }

    return true;
  }

  public function store($updateNulls = false)
  {
    if (!parent::store($updateNulls)) {
      return false;
    }

    $event = $this->getName().'Store';

    FactoryApplication::getInstance()->trigger($event, array($this->media_id, $this->user_id, $this->created_at));

    return true;
  }
}
