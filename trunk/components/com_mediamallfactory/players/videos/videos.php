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

class MediaMallFactoryPlayerVideos extends MediaMallFactoryPlayer
{
  protected $type = 'Videos';

  public function render()
  {
    switch ($this->getFileExtension()) {
      case 'flv':
        $this->renderFlv();
        break;

      case 'swf':
        $this->renderSwf();
        break;

      case 'mov':
        $this->renderMov();
        break;

      case 'wmv':
        $this->renderWmv();
        break;

      case 'avi':
        $this->renderAvi();
        break;
    }
  }

  protected function renderFlv()
  {
    $this->loadAssets(array('js/flowplayer-3.2.11.min.js', 'css/video.css'));

    $this->swf = $this->getAssetPath('swfs/flowplayer-3.2.14.swf');

    $this->renderLayout('video');
  }

  protected function renderSwf()
  {
    $this->loadAssets(array('js/swfobject.js'));

    $this->renderLayout('swf');
  }

  protected function renderMov()
  {
    $this->renderLayout('mov');
  }

  protected function renderWmv()
  {
    $this->renderLayout('wmv');
  }

  protected function renderAvi()
  {
    $this->renderLayout('wmv');
  }
}
