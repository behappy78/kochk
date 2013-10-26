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

class MediaMallFactoryTableMedia extends FactoryTable
{
  protected $media;
  protected $archive;
  protected $thumbnail;
  protected $original;

  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_media', 'id', $db);
  }

  public function addMediaIsPublishedCondition(&$query)
  {
    $query->where('m.published = ' . $query->quote(1));
  }

  public function isAllowedAddReview($user_id = null)
  {
    // Initialise variables.
    if (is_null($user_id)) {
      $user_id = JFactory::getUser()->id;
    }

    // Check if user is logged in.
    if (!$user_id) {
      $this->setError(FactoryText::_('media_allow_add_review_error_guest'));
      return false;
    }

    // Check if user is not media owner
    if ($user_id == $this->user_id) {
      $this->setError(FactoryText::_('media_allow_add_review_error_media_owner'));
      return false;
    }

    // Check if user has not already submitted a review.
    $table = JTable::getInstance('Comment', 'MediaMallFactoryTable');
    $table->load(array('user_id' => $user_id, 'media_id' => $this->id));
    if ($table->id) {
      $this->setError(FactoryText::_('media_allow_add_review_error_only_one_review_allowed'));
      return false;
    }

    // Check if the user has downloaded/viewed the media.
    if (!$this->hasInteractedWithMedia($user_id)) {
      $this->setError(FactoryText::_('media_allow_add_review_error_not_interacted'));
      return false;
    }

    return true;
  }

  public function isAllowedToView($type, $user_id = null)
  {
    if (is_null($user_id)) {
      $user_id = JFactory::getUser()->id;
    }

    // Check if user is media owner or media is free.
    $credits = 'media' == $type ? $this->cost_media : $this->cost_archive;
    if ($this->isOwner($user_id) || !$credits) {
      return true;
    }

    // Check if an active purchase exists.
    $table = FactoryTable::getInstance('Purchase');
    if (!$purchase = $table->findActive($this->id, $user_id, $type)) {
      return false;
    }

    return $purchase;
  }

  public function check()
  {
    // Initialise variables.
    $user = JFactory::getUser();

    if (!parent::check()) {
      return false;
    }

    // Check if media author is set.
    if (!isset($this->user_id) || empty($this->user_id)) {
      $this->user_id = $user->id;
    }

    // Check if we generate thumbnail from media.
    $generate_from_media = FactoryApplication::getInstance()->getParam('general.thumbnails.generate_from_media', 1);
    if ($generate_from_media && is_null($this->thumbnail) && !is_null($this->media) && getimagesize($this->media['tmp_name'])) {
      $this->thumbnail = $this->media;
    }

    // Check if media is new.
    if (!$this->id && JFactory::getApplication()->isSite()) {
      // Check if media needs to be approved first.
      $approve = FactoryApplication::getInstance()->getParam('general.global.approve_media', 1);
      $this->published = $approve ? -1 : 1;

      // Check if author has auto approved media.
      $auto = FactoryApplication::getInstance()->getParam('authors.restrictions.auto_approve', array());
      if (array_intersect($auto, $user->groups)) {
        $this->published = 1;
      }
    }

    // Check if we are on the frontend.
    if (JFactory::getApplication()->isSite()) {
      // Check if author is allowed to set own price.
      $own_price = FactoryApplication::getInstance()->getParam('authors.restrictions.own_price', array());
      if (!array_intersect($own_price, $user->groups)) {
        // Get media type.
        $table = FactoryTable::getInstance('Type');
        $table->load($this->type_id);

        $this->cost_media   = $table->cost_media;
        $this->cost_archive = $table->cost_archive;
      }

      // Check if author is allowed to upload only free media.
      $only_free = FactoryApplication::getInstance()->getParam('authors.restrictions.only_free', array());
      if (array_intersect($only_free, $user->groups)) {
        $this->cost_media   = 0;
        $this->cost_archive = 0;
      }
    }

    return true;
  }

  public function store($updateNulls = false)
  {
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');

    // Check if user folders exist.
    $path = FactoryApplication::getInstance()->getPath('storage_secure').DS.$this->user_id;
    if (!JFolder::exists($path)) {
      JFolder::create($path);
    }
    $path = FactoryApplication::getInstance()->getPath('storage').DS.$this->user_id.DS.'thumbnails';
    if (!JFolder::exists($path)) {
      JFolder::create($path);
    }

    // Keep an original copy of media.
    $this->original = JTable::getInstance('Media', 'MediaMallFactoryTable');
    $this->original->load($this->id);

    if (!parent::store($updateNulls)) {
      return false;
    }

    $this->uploadThumbnail();
    $this->uploadFile('media');
    $this->uploadFile('archive');

    // Check if owner has changed.
    if ($this->original->id && $this->user_id && $this->original->user_id != $this->user_id) {
      $files = array(
        $this->original->getFilePath('media')   => $this->getFilePath('media', false),
        $this->original->getFilePath('archive') => $this->getFilePath('archive', false),
        $this->original->getThumbnailPath(64)   => $this->getThumbnailPath(64),
        $this->original->getThumbnailPath(128)  => $this->getThumbnailPath(128)
      );

      foreach ($files as $src => $dest) {
        if (JFile::exists($src)) {
          JFile::move($src, $dest);
        }
      }
    }
    return true;
  }

  public function delete($pk = null)
  {
    if (!parent::delete($pk)) {
      return false;
    }

    jimport('joomla.filesystem.file');

    $files = array(
      $this->getFilePath('media'),
      $this->getFilePath('archive'),
      $this->getThumbnailPath(64),
      $this->getThumbnailPath(128),
    );

    foreach ($files as $src) {
      if (JFile::exists($src)) {
        JFile::delete($src);
      }
    }

    return true;
  }

  public function download($type = 'media')
  {
    jimport('joomla.filesystem.file');

    $path = $this->getFilePath($type);

    if (false === $path) {
      throw new Exception(FactoryText::sprintf('media_file_not_found', $this->id), 500);
      return false;
    }

    $info = $this->analyzeFile($path);

    header('Content-Type: ' . $info['mime_type'] . "\n");
    header('Content-Length: ' . $info['filesize'] . "\n");
    header('Content-Disposition: filename="' . $this->{'filename_'.$type} . '"' . "\n");

    ob_end_clean();
    echo JFile::read($path);
    ob_start(false);

    $this->downloads++;
    $this->store();
  }

  public function updateRating($rating)
  {
    $this->rating = ($this->rating * $this->votes + $rating) / ($this->votes + 1);
    $this->votes++;

    return parent::store();
  }

  public function getThumbnailSource($size = null)
  {
    if (false === $filename = $this->getThumbnailName($size)) {
      return null;
    }

    return JURI::root().'components/'.FactoryApplication::getInstance()->getOption().'/storage/'.$this->user_id.'/thumbnails/'.$filename;
  }

  public function getThumbnailPath($size = null)
  {
    if (false === $filename = $this->getThumbnailName($size)) {
      return null;
    }

    return FactoryApplication::getInstance()->getPath('storage').DS.$this->user_id.DS.'thumbnails'.DS.$filename;
  }

  public function isOwner($userId = null)
  {
    if (is_null($userId)) {
      $userId = JFactory::getUser()->id;
    }

    return $userId && $userId == $this->user_id;
  }

  public function isPublished()
  {
    // Check if media is published.
    if (1 != $this->published) {
      return false;
    }

    // Check if media type is published.
    $table = FactoryTable::getInstance('Type');
    $table->load($this->type_id);
    if (1 != $table->published) {
      return false;
    }

    // Check if media category is published.
    $table = FactoryTable::getInstance('Category');
    $table->load($this->category_id);
    if (1 != $table->published) {
      return false;
    }

    return true;
  }

  public function isAllowedContact()
  {
    $profile = FactoryTable::getInstance('Profile');
    if (!$profile->load($this->user_id)) {
      return 0;
    }

    return $profile->params->get('allow_contact', 0);
  }

  protected function getThumbnailName($size)
  {
    if (empty($this->filename_thumbnail)) {
      return false;
    }

    jimport('joomla.filesystem.file');
    $name = JFile::stripExt($this->filename_thumbnail);
    $ext  = JFile::getExt($this->filename_thumbnail);

    if (!is_null($size)) {
      $size = '_'.$size;
    }

    return $name.$size.'.'.$ext;
  }

  protected function getFilePath($type = 'media', $exists = true)
  {
    jimport('joomla.filesystem.file');
    $path = FactoryApplication::getInstance()->getPath('storage_secure').DS.$this->user_id.DS.$this->id.'.'.$type;

    if ($exists && (!$this->user_id || !$this->id || !JFile::exists($path))) {
      return false;
    }

    return $path;
  }

  protected function analyzeFile($path)
  {
    static $class = null;
      if (is_null($class)) {
      JLoader::register('getid3', FactoryApplication::getInstance()->getPath('libraries').DS.'getid3'.DS.'getid3.php');
      $class = new getID3();
    }

    return $class->analyze($path);
  }

  protected function hasInteractedWithMedia($user_id = null)
  {
    if (is_null($user_id)) {
      $user_id = JFactory::getUser()->id;
    }

    $log = FactoryTable::getInstance('MediaLog');
    $log->load(array(
      'media_id' => $this->id,
      'user_id'  => $user_id,
    ));

    return $log->id;
  }

  protected function uploadThumbnail()
  {
    if (!is_array($this->thumbnail)) {
      return true;
    }

    // Initialise variables.
    $path      = FactoryApplication::getInstance()->getPath('storage').DS.$this->user_id.DS.'thumbnails';
    $name      = JApplication::stringURLSafe(JFile::stripExt($this->thumbnail['name'])).'-'.$this->id;
    $extension = JApplication::stringURLSafe(JFile::getExt($this->thumbnail['name']));
    $small     = FactoryApplication::getInstance()->getParam('general.thumbnails.small_media_width', 64);
    $large     = FactoryApplication::getInstance()->getParam('general.thumbnails.large_media_width', 128);
    $quality   = FactoryApplication::getInstance()->getParam('general.thumbnails.quality', 80);

    $widths = array($small, $large);

    foreach ($widths as $width) {
      // Delete original thumbnail.
      if (JFile::exists($this->original->getThumbnailPath($width))) {
        JFile::delete($this->original->getThumbnailPath($width));
      }

      // Create new thumbnail.
      SimpleImage::getInstance()
        ->load($this->thumbnail['tmp_name'])
        ->resizeToWidth($width)
        ->save($path.DS.$name.'_'.$width.'.'.$extension, IMAGETYPE_JPEG, $quality);
    }

    $table = JTable::getInstance('Media', 'MediaMallFactoryTable');

    $table->bind(array(
      'id' => $this->id,
      'filename_thumbnail' => $name.'.'.$extension,
    ));

    if (!$table->store()) {
      return false;
    }

    return true;
  }

  protected function uploadFile($type = 'media')
  {
    if (!is_array($this->$type)) {
      return true;
    }

    $path = FactoryApplication::getInstance()->getPath('storage_secure').DS.$this->user_id;
    if (!JFile::upload($this->{$type}['tmp_name'], $path.DS.$this->id.'.'.$type)) {
      return false;
    }

    $table = JTable::getInstance('Media', 'MediaMallFactoryTable');

    $table->bind(array(
      'id'              => $this->id,
      'filename_'.$type => $this->{$type}['name'],
      'has_'.$type      => 1,
    ));

    if (!$table->store()) {
      return false;
    }

    return true;
  }
}
