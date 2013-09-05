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

class MediaMallFactoryFrontendModelMedia extends JModel
{
  protected $media_id;

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->media_id = JFactory::getApplication()->input->getInt('media_id', 0);
  }

  public function getItem($media_id = null)
  {
    static $items = array();

    if (is_null($media_id)) {
      $media_id = $this->media_id;
    }

    if (!isset($items[$media_id])) {
      $table = FactoryTable::getInstance('Media');

      $table->load($media_id);

      if (!$table->isPublished() && !$table->isOwner()) {
        throw new Exception(FactoryText::sprintf('media_not_found', $media_id), 404);
      }

      $items[$media_id] = $table;
    }

    return $items[$media_id];
  }

  public function getThumbnailWidth()
  {
    return FactoryApplication::getInstance()->getParam('general.thumbnails.large_media_width', 128);
  }

  public function getReviews()
  {
    $factoryApp = FactoryApplication::getInstance();
    JLoader::register('MediaMallFactoryFrontendViewComments', $factoryApp->getPath('component').DS.'views'.DS.'comments'.DS.'view.html.php');

    $view  = new MediaMallFactoryFrontendViewComments();
    $model = JModel::getInstance('Comments', 'MediaMallFactoryFrontendModel', array('media_id' => $this->media_id));

    $view->setModel($model, true);

    return $view;
  }

  public function getReview()
  {
    $factoryApp = FactoryApplication::getInstance();
    JLoader::register('MediaMallFactoryFrontendViewComment', $factoryApp->getPath('component').DS.'views'.DS.'comment'.DS.'view.html.php');

    $view  = new MediaMallFactoryFrontendViewComment();
    $model = JModel::getInstance('Comment', 'MediaMallFactoryFrontendModel', array('media_id' => $this->media_id));

    $view->setModel($model, true);

    return $view;
  }

  public function getAuthor()
  {
    static $authors = array();
    $item = $this->getItem();

    if (!isset($authors[$item->user_id])) {
      $table = FactoryTable::getInstance('Profile');
      $table->load($item->user_id);

      $authors[$item->user_id] = $table;
    }

    return $authors[$item->user_id];
  }

  public function getAuthorUsername()
  {
    $author = $this->getAuthor();

    return JFactory::getUser($author->user_id)->username;
  }

  public function getType($media_id = null)
  {
    if (is_null($media_id)) {
      $media_id = $this->media_id;
    }

    $item = $this->getItem($media_id);

    $table = JTable::getInstance('Type', 'MediaMallFactoryTable');
    $table->load($item->type_id);

    return $table;
  }

  public function getCategory($media_id = null)
  {
    if (is_null($media_id)) {
      $media_id = $this->media_id;
    }

    $item = $this->getItem($media_id);

    $table = JTable::getInstance('Category');
    $table->load($item->category_id);

    return $table;
  }

  public function getPurchases($media_id = null, $user_id = null)
  {
    JLoader::register('MediaMallFactoryTablePurchase', FactoryApplication::getInstance()->getPath('component_administrator').DS.'tables'.DS.'purchase.php');

    if (is_null($media_id)) {
      $media_id = $this->media_id;
    }

    if (is_null($user_id)) {
      $user_id = JFactory::getUser()->id;
    }

    $timelimit = FactoryApplication::getInstance()->getParam('general.global.view_timelimit', 30);
    $limit = JFactory::getDate('- ' . $timelimit . ' seconds')->toSql();

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('p.*')
      ->from('#__mediamallfactory_purchases p')
      ->where('p.media_id = ' . $dbo->quote($media_id))
      ->where('p.user_id = ' . $dbo->quote($user_id))
      ->where('(p.active = ' .$dbo->quote(1) . ' OR p.last_viewed_at > ' . $dbo->quote($limit) . ')');
    $results = $dbo->setQuery($query)
      ->loadObjectList('type', 'MediaMallFactoryTablePurchase');

    return $results;
  }

  public function purchase($media_id, $user_id, $type)
  {
    // Check if media exists and it's published.
    $media = $this->getItem($media_id);
    if ($media->id != $media_id) {
      $this->setError(FactoryText::sprintf('media_purchase_error_media_not_found', $media_id));
      return false;
    }

    // Check if an active purchase was found.
    $purchase = FactoryTable::getInstance('Purchase');
    if ($purchase->findActive($media_id, $user_id, $type, true)) {
      $this->setError(FactoryText::sprintf('media_purchase_error_already_purchased', $media_id));
      return false;
    }

    // Check if user has enough credits to purchase the media.
    $user = FactoryTable::getInstance('Profile');
    $user->load($user_id);

    // Get credits cost.
    if ('media' == $type) {
      $credits = $media->cost_media;
    } elseif ('archive' == $type) {
      $credits = $media->cost_archive;
    } else {
      $credits = FactoryApplication::getInstance()->getParam('general.credits.cost_contact', 1);
    }

    if ($user->credits < $credits) {
      $this->setError(FactoryText::sprintf('media_purchase_error_not_enough_credits', $media_id));
      return false;
    }

    if ('contact' == $type) {
      $unlimited = true;
    } else {
      $unlimited = FactoryApplication::getInstance()->getParam('general.global.unlimited_views', 0);
    }

    // Purchase new media views.
    $credits_rate = FactoryApplication::getInstance()->getParam('general.credits.rate', 0.5);
    $amount       = $credits_rate * $credits;

    if ($unlimited) {
      $views = 0;
    } else {
      if ('archive' == $type) {
        $views = 1;
      } else {
        $table = $this->getType($media_id);
        $views = $table->getViews();
      }
    }

    if (false === $purchase_id = $purchase->create($media_id, $type, $views, $credits, $amount, $media->user_id, $user_id)) {
      $this->setError($purchase->getError());
      return false;
    }

    // Update buyer credits.
    $user->updateCredits(-1 * $credits);

    // Trigger event.
    FactoryApplication::getInstance()->trigger('creditsUpdate', array(
      -1 * $credits, $user_id, 'MediaPurchase', array(
        'media_id'    => $media_id,
        'purchase_id' => $purchase_id,
        'type'        => $type)
    ));

    // Update author balance.
    $author = FactoryTable::getInstance('Profile');
    $author->load($media->user_id);

    $percent = FactoryApplication::getInstance()->getParam('authors.global.author_percent', 80);
    $amount = ($percent / 100) * $amount;

    $author->updateBalance($amount);

    // Trigger event.
    FactoryApplication::getInstance()->trigger('balanceUpdate', array(
      $amount, $author->user_id, 'MediaSell', array(
        'media_id'    => $media_id,
        'purchase_id' => $purchase_id,
        'type'        => $type)
    ));

    // Trigger media sold event.
    FactoryApplication::getInstance()->trigger('mediaPurchase', array(
      $media_id, $media->title, $user_id, $author->user_id, $purchase->created_at
    ));

    return true;
  }

  public function purchaseCategory($category_id, $user_id)
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('m.id')
      ->from('#__mediamallfactory_media m')
      ->where('m.category_id = ' . $dbo->quote($category_id))
      ->where('m.user_id <> ' . $dbo->quote($user_id))
      ->where('m.cost_media <> 0');

    $query->leftJoin('#__mediamallfactory_purchases p ON p.media_id = m.id AND p.active = ' . $dbo->quote(1))
      ->where('p.id IS NULL');

    $results = $dbo->setQuery($query)
      ->loadResultArray();

    foreach ($results as $media_id) {
      if (!$this->purchase($media_id, $user_id, 'media')) {
        return false;
      }
    }

    return true;
  }
}
