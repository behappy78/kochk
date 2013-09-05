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

class FactoryApplication
{
  protected $option;
  protected $app;
  protected $component;
  protected $input;
  protected $dispatcher;

  public function __construct($config = array())
  {
    if (isset($config['app'])) {
      $this->app = $config['app'];
    } else {
      $this->app = JFactory::getApplication();
    }

    if (isset($config['dispatcher'])) {
      $this->dispatcher = $config['dispatcher'];
    } else {
      $this->dispatcher = JDispatcher::getInstance();
    }

    $this->input = $this->app->input;

    if (isset($config['option'])) {
      $this->option = $config['option'];
    } else {
      $this->option = $this->input->getCmd('option', '');
    }

    if (isset($config['component'])) {
      $this->component = $config['component'];
    } else {
      $this->component = str_replace('com_', '', $this->option);
    }

    $this->includeDependencies();
    $this->registerEvents();
  }

  public static function getInstance($config = array())
  {
    static $instance = null;

    if (is_null($instance)) {
      $instance = new self($config);
    }

    return $instance;
  }

  public function run()
  {
    $post = JRequest::get('post');
    $method = JFactory::getApplication()->input->getMethod();

    if ('POST' == $method && !$post) {
      JError::raiseWarning(0, FactoryText::_('error_post_empty'));
    }

    // Create class name.
    $class = $this->component . ($this->app->isSite() ? 'Frontend' : 'Backend');

    // Initialise and execute controller.
    $controller	= JController::getInstance($class);
    $controller->execute($this->input->getCmd('task', ''));
    $controller->redirect();
  }

  public function getComponent()
  {
    return $this->component;
  }

  public function getOption()
  {
    return $this->option;
  }

  public function getPath($src)
  {
    $path = '';

    switch ($src) {
      case 'libraries':
        $path = JPATH_ADMINISTRATOR.DS.'components'.DS.$this->option.DS.'libraries';
        break;

      case 'factory':
        $path = $this->getPath('libraries').DS.'factory';
        break;

      case 'component':
        $path = JPATH_BASE.DS.'components'.DS.$this->option;
        break;

      case 'component_site':
        $path = JPATH_SITE.DS.'components'.DS.$this->option;
        break;

      case 'component_administrator':
        $path = JPATH_ADMINISTRATOR.DS.'components'.DS.$this->option;
        break;

      case 'players':
        $path = $this->getPath('component_site').DS.'players';
        break;

      case 'storage':
        $path = $this->getPath('component_site').DS.'storage';
        break;

      case 'storage_secure':
        $path = $this->getPath('component_site').DS.'storage_secure';
        break;

      case 'views':
        $path = $this->getPath('component').DS.'views';
        break;

      case 'payment_gateways':
        $path = $this->getPath('payment').DS.'gateways';
        break;

      case 'payment':
        $path = $this->getPath('component_administrator').DS.'payment';
        break;

      case 'categories_thumbnails':
        $path = $this->getPath('storage').DS.'thumbnails';
        break;
    }

    return $path;
  }

  public function getParam($name, $value = null)
  {
    return $this->getParams()->get($name, $value);
  }

  public function getParams()
  {
     return JComponentHelper::getParams($this->getOption());
  }

  public function loadLanguage($location = 'site', $type = '')
  {
    $location = 'site' == $location ? JPATH_SITE : JPATH_ADMINISTRATOR;

    $type = '' == $type ? $type : '.'.$type;

    $language = JFactory::getLanguage();
    $language->load($this->getOption().$type, $location);
  }

  public function trigger($event, $args = array())
  {
    $event = 'on' . $this->getComponent() . $event;

    $this->dispatcher->trigger($event, $args);

    if (defined('JDEBUG') && JDEBUG) {
      JLog::add(sprintf('Triggerd event: %s', $event), JLog::DEBUG, 'event');
    }
  }

  public function checkPermission($permission)
  {
    $user = JFactory::getUser();

    switch ($permission) {
      case 'logged':
        if ($user->guest) {
          $this->app->enqueueMessage(FactoryText::_('permissions_you_must_login_first'), 'error');
          $this->app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
          return false;
        }
        break;

      case 'author':
        $authors = $this->getParam('authors.global.author', array());

        if (!array_intersect($authors, $user->groups)) {
          throw new Exception(FactoryText::_('permissions_only_authors_are_allowed'), 403);
        }
        break;

      case 'guestfreemedia':
        $access = $this->getParam('general.global.free_media_guests', 0);
        if ($user->guest && !$access) {
          return $this->checkPermission('logged');
        }
        break;

      case 'limitedUploads':
        $media_id        = JFactory::getApplication()->input->getInt('media_id', 0);
        $limited_uploads = FactoryApplication::getInstance()->getParam('authors.restrictions.limited_uploads', array());
        if (!$media_id && array_intersect($limited_uploads, $user->groups)) {
          $limit = FactoryApplication::getInstance()->getParam('authors.restrictions.limited_uploads_value', 0);

          // Get user media count.
          $model = JModel::getInstance('Profile', 'MediaMallFactoryFrontendModel');

          if ($model->getMediaCount() >= $limit) {
            throw new Exception(FactoryText::_('permissions_cannot_upload_any_more_media'), 403);
          }
        }
        break;

      case 'editMedia':
        $media_id       = JFactory::getApplication()->input->getInt('media_id', 0);
        $edit_own_media = FactoryApplication::getInstance()->getParam('authors.restrictions.edit_own_media', array());

        if ($media_id && !array_intersect($edit_own_media, $user->groups)) {
          throw new Exception(FactoryText::_('permissions_cannot_edit_own_media'), 403);
        }
        break;
    }
  }

  protected function includeDependencies()
  {
    jimport('joomla.application.component.controller');
    jimport('joomla.application.component.controlleradmin');
    jimport('joomla.application.component.controllerform');
    jimport('joomla.application.component.model');
    jimport('joomla.application.component.modellist');
    jimport('joomla.application.component.modeladmin');

    JLoader::register('FactoryView',        $this->getPath('factory').DS.'view.php');
    JLoader::register('FactoryRoute',       $this->getPath('factory').DS.'methods.php');
    JLoader::register('FactoryHtml',        $this->getPath('factory').DS.'methods.php');
    JLoader::register('FactoryText',        $this->getPath('factory').DS.'methods.php');
    JLoader::register('FactoryForm',        $this->getPath('factory').DS.'methods.php');
    JLoader::register('FactoryMailer',      $this->getPath('factory').DS.'methods.php');
    JLoader::register('JHtmlFactory',       $this->getPath('factory').DS.'html.php');
    JLoader::register('JHtmlFactoryAdmin',  $this->getPath('factory').DS.'html'.DS.'admin.php');
    JLoader::register('FactoryTable',       $this->getPath('factory').DS.'table.php');
    JLoader::register('FactoryFormFilters', $this->getPath('factory').DS.'formfilters.php');
    JLoader::register('SimpleImage',        $this->getPath('libraries').DS.'resize.php');
    JLoader::register('FactoryModelAdminList', $this->getPath('factory').DS.'modeladminlist.php');
    JLoader::register('FactoryPaymentGateway', $this->getPath('payment').DS.'gateway.php');
    JLoader::register('FactoryPaymentNotification', $this->getPath('payment').DS.'notification.php');
  }

  protected function registerEvents()
  {
    if (defined('JDEBUG') && JDEBUG) {
			JLog::addLogger(array('text_file' => 'com_mediamallfactory.events.php'), JLog::ALL, array('event'));
		}

    // Register events files.
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');

    $files = JFolder::files($this->getPath('component_site').DS.'events', '.', false, true);
    foreach ($files as $file) {
      $name = JFile::getName(JFile::stripExt($file));
      $class = 'MediaMallFactoryEvent' . ucfirst($name);

      JLoader::register($class, $file);
    }

    // Register events.
    $xml = JFactory::getXML($this->getPath('component_site').DS.'events.xml');
    $dispatcher = JDispatcher::getInstance();
    foreach ($xml->event as $event) {
      if ('false' == (string)$event->attributes()->enabled) {
        continue;
      }

      $type = (string)$event->attributes()->type;
      $type = 0 === strpos($type, 'on') ? $type : 'onMediaMallFactory' . ucfirst($type);

      if (!is_null($event->attributes()->handler)) {
        $handlers = array('MediaMallFactoryEvent' . ucfirst((string)$event->attributes()->handler));
      } else {
        $handlers = array();

        foreach ($event->children()->handler as $handler) {
          if ('false' == (string)$handler->attributes()->enabled) {
            continue;
          }

          $handlers[] = 'MediaMallFactoryEvent' . ucfirst((string)$handler);
        }
      }

      foreach ($handlers as $handler) {
        $dispatcher->register($type, $handler);

//        if (defined('JDEBUG') && JDEBUG) {
//          JLog::add(sprintf('Registered event: %s, handler: %s', $type, $handler), JLog::DEBUG, 'event');
//        }
      }
    }
  }

  // Developer functions.
  public function createView($name)
  {
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');

    // Check if views folder is created.
    $folder = $this->getPath('component').DS.'views';
    if (!JFolder::exists($folder)) {
      JFolder::create($folder);
    }

    // Delete existing folder.
    $folder .= DS.strtolower($name);
    if (JFolder::exists($folder)) {
      JFolder::delete($folder);
    }

    // Create folder.
    JFolder::create($folder);
    JFolder::create($folder.DS.'tmpl');

    // Create index files.
    JFile::write($folder.DS.'index.html', $this->getBlankIndexContents());
    JFile::write($folder.DS.'tmpl'.DS.'index.html', $this->getBlankIndexContents());

    // Create view file.
    $contents = JFile::read($this->getPath('factory').DS.'stubs'.DS.'view.html.php');
    $contents = str_replace(
      array('[COMPONENT]', '[CLIENT]', '[CLASSNAME]'),
      array(ucfirst($this->component), ($this->app->isSite() ? 'Frontend' : 'Backend'), ucfirst($name)),
      $contents);
    JFile::write($folder.DS.'view.html.php', $contents);

    // Create template file.
    $contents = JFile::read($this->getPath('factory').DS.'stubs'.DS.'default.php');
    $contents = str_replace(
      array('[CLASSNAME]'),
      array(ucfirst($name)),
      $contents);
    JFile::write($folder.DS.'tmpl'.DS.'default.php', $contents);

    return true;
  }

  public function createModel($name)
  {
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');

    // Check if views folder is created.
    $folder = $this->getPath('component').DS.'models';
    if (!JFolder::exists($folder)) {
      JFolder::create($folder);
    }

    // Create model file.
    $contents = JFile::read($this->getPath('factory').DS.'stubs'.DS.'model.php');
    $contents = str_replace(
      array('[COMPONENT]', '[CLIENT]', '[CLASSNAME]'),
      array(ucfirst($this->component), ($this->app->isSite() ? 'Frontend' : 'Backend'), ucfirst($name)),
      $contents);
    JFile::write($folder.DS.strtolower($name.'.php'), $contents);

    return true;
  }

  public function createModelList($name)
  {
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');

    // Check if views folder is created.
    $folder = $this->getPath('component').DS.'models';
    if (!JFolder::exists($folder)) {
      JFolder::create($folder);
    }

    // Create model file.
    $contents = JFile::read($this->getPath('factory').DS.'stubs'.DS.'modellist.php');
    $contents = str_replace(
      array('[COMPONENT]', '[CLIENT]', '[CLASSNAME]'),
      array(ucfirst($this->component), ($this->app->isSite() ? 'Frontend' : 'Backend'), ucfirst($name)),
      $contents);
    JFile::write($folder.DS.strtolower($name.'.php'), $contents);

    return true;
  }

  protected function getBlankIndexContents()
  {
    return '<!DOCTYPE html><title></title>';
  }
}
