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

class MediaMallFactoryTableCreditsLog extends FactoryTable
{
  public $pending = 1;

  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_log_credits', 'id', $db);
  }

  public function record($credits, $user_id, $type, $variables = array())
  {
    $method = 'record' . $type;

    if (!method_exists($this, $method)) {
      return false;
    }

    $sign = $credits < 0 ? -1 : 1;
    $credits = $sign == -1 ? -1 * $credits : $credits;

    return $this->$method($credits, $sign, $user_id, $variables);
  }

  public function recordMediaPurchase($credits, $sign, $user_id, $variables)
  {
    $table = JTable::getInstance('CreditsLog', 'MediaMallFactoryTable');

    $table->user_id     = $user_id;
    $table->type        = 'media_purchased_'.$variables['type'];
    $table->credits     = $credits;
    $table->sign        = $sign;
    $table->media_id    = $variables['media_id'];
    $table->purchase_id = $variables['purchase_id'];

    return $table->store();
  }

  public function recordInitial($credits, $sign, $user_id)
  {
    $table = JTable::getInstance('CreditsLog', 'MediaMallFactoryTable');

    $table->user_id = $user_id;
    $table->type    = 'initial_credits';
    $table->credits = $credits;
    $table->sign    = $sign;

    return $table->store();
  }

  public function recordConvertFunds($credits, $sign, $user_id)
  {
    $table = FactoryTable::getInstance('CreditsLog');

    $table->user_id = $user_id;
    $table->type    = 'converted_funds';
    $table->credits = $credits;
    $table->sign    = $sign;

    return $table->store();
  }

  public function recordCreditsPurchase($credits, $sign, $user_id)
  {
    $table = FactoryTable::getInstance('CreditsLog');

    $table->user_id = $user_id;
    $table->type    = 'credits_purchased';
    $table->credits = $credits;
    $table->sign    = $sign;

    return $table->store();
  }

  public function recordDownloadArchive($credits, $sign, $user_id, $variables)
  {
    $table = JTable::getInstance('CreditsLog', 'MediaMallFactoryTable');

    $table->user_id  = $user_id;
    $table->type     = 'archive_downloaded';
    $table->credits  = $credits;
    $table->sign     = $sign;
    $table->media_id = $variables['media_id'];

    return $table->store();
  }

  public function recordAdmin($credits, $sign, $user_id)
  {
    $table = FactoryTable::getInstance('CreditsLog');

    $table->user_id  = $user_id;
    $table->type     = 'admin';
    $table->credits  = $credits;
    $table->sign     = $sign;

    return $table->store();
  }
}
