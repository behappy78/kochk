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

class MediaMallFactoryEventLog extends JEvent
{
  public function onMediaMallFactoryCreditsUpdate($credits, $user_id, $type, $variables = array())
  {
    // Log user credits.
    $log = FactoryTable::getInstance('CreditsLog');

    return $log->record($credits, $user_id, $type, $variables);
  }

  public function onMediaMallFactoryBalanceUpdate($amount, $user_id, $type, $variables = array())
  {
    // Log author balance.
    $log = FactoryTable::getInstance('BalanceLog');

    return $log->record($amount, $user_id, $type, $variables);
  }

  public function onMediaMallFactoryMediaDownload($mediaId, $userId, $type)
  {
    $log = FactoryTable::getInstance('MediaLog');

    return $log->record($mediaId, $userId, $type);
  }
}
