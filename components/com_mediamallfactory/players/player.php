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

abstract class MediaMallFactoryPlayer
{
  protected $source;
  protected $name;
  protected $media;

  public function __construct($config = array())
  {
  }

  abstract function render();

  public static function getInstance($type)
  {
    static $instances = array();
    $type = strtolower($type);

    if (!isset($instances[$type])) {
      $class = 'MediaMallFactoryPlayer'.ucfirst($type);

      if (!class_exists($class)) {
        jimport('joomla.filesystem.file');
        $path = FactoryApplication::getInstance()->getPath('players').DS.$type.DS.$type.'.php';
        if (!JFile::exists($path)) {
          throw new Exception(FactoryText::sprintf('player_error_not_found', $type), 500);
          return false;
        }

        require_once $path;
      }

      if (!class_exists($class)) {
        throw new Exception(FactoryText::sprintf('player_error_not_found', $type), 500);
      }

      $instances[$type] = new $class();
    }

    return $instances[$type];
  }

  public function setSource($source)
  {
    $this->source = $source;
  }

  public function getSource()
  {
    return $this->source;
  }

  public function getTitle()
  {
    return $this->getMedia()->title;
  }

  public function setMedia($media)
  {
    $this->media = $media;
  }

  public function getMedia()
  {
    return $this->media;
  }

  public function getFileExtension()
  {
    jimport('joomla.filesystem.file');

    return JFile::getExt($this->media->filename_media);
  }

  protected function getName()
  {
    if (!isset($this->name)) {
      $this->name = str_replace('MediaMallFactoryPlayer', '', get_class($this));
    }

    return $this->name;
  }

  protected function loadAssets($assets = array())
  {
    foreach ($assets as $asset) {
      if (false !== strpos($asset, '.js')) {
        JHtml::script($this->getAssetPath($asset));
      } elseif (false !== strpos($asset, '.css')) {
        JHtml::stylesheet($this->getAssetPath($asset));
      }
    }
  }

  protected function getAssetPath($asset)
  {
    return JURI::root().'components/com_mediamallfactory/players/'.strtolower($this->getName()).'/assets/'.$asset;
  }

  protected function renderLayout($layout)
  {
    jimport('joomla.filesystem.file');
    $base = FactoryApplication::getInstance()->getPath('players').DS.strtolower($this->getName());
    $path = $base.DS.'layouts'.DS.$layout.'.php';

    if (!JFile::exists($path)) {
      throw new Exception(FactoryText::sprintf('player_layout_not_found', $layout), 500);
      return false;
    }

    require $path;
  }
}
