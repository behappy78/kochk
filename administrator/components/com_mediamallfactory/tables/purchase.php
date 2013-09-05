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

class MediaMallFactoryTablePurchase extends FactoryTable
{
  public $pending_seller = 1;
  public $pending_buyer  = 1;

  public function __construct(&$db = null)
  {
    if (is_null($db)) {
      $db = JFactory::getDbo();
    }

    parent::__construct('#__mediamallfactory_purchases', 'id', $db);
  }

  public function create($media_id, $type, $views, $credits, $amount, $author_id, $user_id = null)
  {
    if (is_null($user_id)) {
      $user_id = JFactory::getUser()->id;
    }

    $this->media_id     = $media_id;
    $this->views_bought = $views;
    $this->user_id      = $user_id;
    $this->active       = 1;
    $this->credits      = $credits;
    $this->amount       = $amount;
    $this->author_id    = $author_id;
    $this->type         = $type;

    if (!$this->store()) {
      return false;
    }

    return $this->id;
  }

  public function getViewsRemaining()
  {
    // Check if unlimited views were bought.
    if (!$this->views_bought) {
      return $this->views_bought;
    }

    // Check if we are in the view time limit period.
    if ($this->isViewTimelimit()) {
      return -1;
    }

    return $this->views_bought - $this->views_seen;
  }

  public function updateViews()
  {
    // Check if we are in the view time limit period.
    if ($this->isViewTimelimit()) {
      return -1;
    }

    $this->views_seen++;
    $this->last_viewed_at = JFactory::getDate()->toSql();

    if ($this->views_bought > 0 && $this->views_seen == $this->views_bought) {
      $this->active = 0;
    }

    return $this->store();
  }

  public function findActive($media_id, $user_id, $type, $strict = false)
  {
    $limit = $this->getLimit();

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('p.*')
      ->from('#__mediamallfactory_purchases p')
      ->where('p.media_id = ' . $dbo->quote($media_id))
      ->where('p.user_id = ' . $dbo->quote($user_id))
      ->where('p.type = ' . $dbo->quote($type));

    if ($strict) {
      $query->where('p.active = ' .$dbo->quote(1));
    } else {
      $query->where('(p.active = ' .$dbo->quote(1) . ' OR p.last_viewed_at > ' . $dbo->quote($limit) . ')');
    }

    $result = $dbo->setQuery($query)
      ->loadObject('MediaMallFactoryTablePurchase');

    return $result ? $result : false;
  }

  protected function getLimit()
  {
    $timelimit = FactoryApplication::getInstance()->getParam('general.global.view_timelimit', 30);

    return JFactory::getDate('- ' . $timelimit . ' seconds')->toSql();
  }

  protected function isViewTimelimit()
  {
    $limit = $this->getLimit();

    if ($this->last_viewed_at != JFactory::getDbo()->getNullDate() && $this->last_viewed_at > $limit) {
      return true;
    }

    return false;
  }
}
