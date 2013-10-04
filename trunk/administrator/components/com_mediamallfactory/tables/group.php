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

class MediaMallFactoryTableGroup extends FactoryTable
{
  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_groups', 'id', $db);
  }

  public function getViews()
  {
    $unlimited = FactoryApplication::getInstance()->getParam('general.global.unlimited_views', 0);
    if ($unlimited) {
      return 0;
    }

    return $this->views;
  }
}