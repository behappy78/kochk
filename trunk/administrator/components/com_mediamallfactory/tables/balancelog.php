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

class MediaMallFactoryTableBalanceLog extends FactoryTable
{
  public $pending = 1;

  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_log_balance', 'id', $db);
  }

  public function record($amount, $user_id, $type, $variables = array())
  {
    $method = 'record' . $type;

    if (!method_exists($this, $method)) {
      return false;
    }

    $sign   = $amount < 0 ? -1 : 1;
    $amount = $sign == -1 ? -1 * $amount : $amount;

    return $this->$method($amount, $sign, $user_id, $variables);
  }

  public function recordMediaSell($amount, $sign, $user_id, $variables)
  {
    $table = JTable::getInstance('BalanceLog', 'MediaMallFactoryTable');

    $table->user_id     = $user_id;
    $table->type        = 'media_sale_'.$variables['type'];
    $table->amount      = $amount;
    $table->sign        = $sign;
    $table->media_id    = $variables['media_id'];
    $table->purchase_id = $variables['purchase_id'];

    return $table->store();
  }

  public function recordConvertFunds($amount, $sign, $user_id)
  {
    $table = FactoryTable::getInstance('BalanceLog');

    $table->user_id     = $user_id;
    $table->type        = 'converted_funds';
    $table->amount      = $amount;
    $table->sign        = $sign;

    return $table->store();
  }

  public function recordWithdrawnFunds($amount, $sign, $user_id)
  {
    $table = FactoryTable::getInstance('BalanceLog');

    $table->user_id = $user_id;
    $table->type    = 'withdrawn_funds';
    $table->amount  = $amount;
    $table->sign    = $sign;

    return $table->store();
  }

  public function recordDownloadArchive($amount, $sign, $user_id, $variables)
  {
    $table = FactoryTable::getInstance('BalanceLog');

    $table->user_id  = $user_id;
    $table->type     = 'download_archive';
    $table->amount   = $amount;
    $table->sign     = $sign;
    $table->media_id = $variables['media_id'];

    return $table->store();
  }

  public function recordAdmin($amount, $sign, $user_id)
  {
    $table = FactoryTable::getInstance('BalanceLog');

    $table->user_id  = $user_id;
    $table->type     = 'admin';
    $table->amount   = $amount;
    $table->sign     = $sign;

    return $table->store();
  }
}
