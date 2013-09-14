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

jimport('joomla.application.component.view');

class FactoryView extends JView
{
  protected
    $buttons   = array(),
    $css       = array(),
    $js        = array(),
    $title     = 'title',
    $id        = 'id',
    $behaviors = array(),
    $get       = array(),
    $html      = array(),
    $jtexts    = array(),
    $tpl       = null
  ;

  public function __construct($config = array())
  {
    parent::__construct($config);

    jimport('joomla.filesystem.file');
    $path = FactoryApplication::getInstance()->getPath('views').DS.$this->getName().DS.'permissions.xml';

    if (JFile::exists($path)) {
      $xml = JFactory::getXML($path);

      foreach ($xml->permission as $permission) {
        FactoryApplication::getInstance()->checkPermission((string)$permission->attributes()->type);
      }
    }
  }

  public function display($tpl = null)
  {
    foreach ($this->get as $get) {
      $this->{$get} = $this->get($get);
    }

    $this->addToolbar();
    $this->loadAssets();
    $this->createPathway();

    if (is_null($tpl)) {
      $tpl = $this->tpl;
    }
    parent::display($tpl);
  }

  public function loadTemplate($tpl = null, $vars = array())
	{
    foreach ($vars as $var => $value) {
      $this->$var = $value;
    }

    if (false !== strpos($tpl, '/')) {
      list($view, $tpl) = explode('/', $tpl);

      $path = FactoryApplication::getInstance()->getPath('views');

      if ('' == $view) {
        $view = 'tmpl';
      } else {
        $view = $view.DS.'tmpl';
      }

      $this->_path['template'][] = $path.DS.$view;
    }

    return parent::loadTemplate($tpl);
	}

  protected function addToolbar()
  {
    if (!JFactory::getApplication()->isAdmin()) {
      return false;
    }

    // Set title
    $this->setTitle();

    // Add buttons
    foreach ($this->buttons as $button) {
      switch ($button) {
        case '':
          JToolBarHelper::divider();
          break;

        case 'add':
          JToolBarHelper::addNew(rtrim($this->getName(), 's').'.add');
          break;

        case 'edit':
          JToolBarHelper::editList(rtrim($this->getName(), 's').'.edit');
          break;

        case 'publish':
          JToolBarHelper::publishList($this->getName().'.publish');
          break;

        case 'unpublish':
          JToolBarHelper::unpublishList($this->getName().'.unpublish');
          break;

        case 'delete':
          JToolBarHelper::deleteList(FactoryText::_('list_delete'), $this->getName().'.delete');
          break;

        case 'apply':
          JToolBarHelper::apply($this->getName().'.apply');
          break;

        case 'save':
          JToolBarHelper::save($this->getName().'.save');
          break;

        case 'save2new':
          JToolBarHelper::save2new($this->getName().'.save2new');
          break;

        case 'close':
          JToolBarHelper::cancel($this->getName().'.cancel', (isset($this->item) && $this->item->{$this->id} ? 'JTOOLBAR_CLOSE' : 'JTOOLBAR_CANCEL'));
          break;

        case 'back':
          JToolBarHelper::back();
          break;

        default:
          JToolBarHelper::custom($this->getName().'.' . $button[0], $button[2], $button[2], FactoryText::_($button[1]), $button[3]);
          break;
      }
    }

    // Set view icon.
    jimport('joomla.filesystem.file');
    $path = FactoryApplication::getInstance()->getPath('component_administrator').DS.'assets'.DS.'images'.DS.'views';
    $name = $this->getName().'.png';
    if (JFile::exists($path.DS.$name)) {
      $document = JFactory::getDocument();
      $document->addStyleDeclaration('.icon-48-generic {background-image: url("components/com_mediamallfactory/assets/images/views/'.$name.'");}');
    }

    return true;
  }

  protected function loadAssets()
  {
    // Initialise variables.
    $name       = $this->getName();
    $factoryApp = FactoryApplication::getInstance();
    $prefix     = JFactory::getApplication()->isAdmin() ? 'admin/' : '';

    // Load behaviors.
    foreach ($this->behaviors as $behavior) {
      if (0 === strpos($behavior, 'factory')) {
        $behavior = str_replace('factory', '', $behavior);
        JHtml::_('Factory.behavior', $behavior);
      } else {
        JHtml::_('behavior.'.$behavior);
      }
    }

    // Load CSS files.
    $this->css[] = $prefix . 'views/' . strtolower($this->getName());
    foreach ($this->css as $css) {
      FactoryHtml::stylesheet($css);
    }

    // Load Javascript files.
    $this->js[] = $prefix . 'views/' . strtolower($this->getName());
    foreach ($this->js as $js) {
      FactoryHtml::script($js);
    }

    // Register default component Html helper.
    JLoader::register(
      'JHtml'.$factoryApp->getComponent(),
      $factoryApp->getPath('component_site').DS.'html'.DS.'html.php');

    // Register default view Html helper.
    JLoader::register(
      'JHtml'.$factoryApp->getComponent().ucfirst($name),
      $factoryApp->getPath('component').DS.'html'.DS.strtolower($name).'.php');

    // Register specified Html helpers
    foreach ($this->html as $html) {
      $location = 'component';

      if (false !== strpos($html, '/')) {
        list($suffix, $html) = explode('/', $html);
        $location .= '_' . $suffix;
      }

      JLoader::register(
        'JHtml'.$factoryApp->getComponent().ucfirst($html),
        $factoryApp->getPath($location).DS.'html'.DS.strtolower($html).'.php');
    }

    // Render JTexts
    foreach ($this->jtexts as $jtext) {
      JText::script($jtext);
    }
  }

  protected function createPathway()
  {
    if (!JFactory::getApplication()->isSite()) {
      return false;
    }

    $pathway = JFactory::getApplication()->getPathway();
    $items = $this->get('Pathway');

    if (!$items) {
      return false;
    }

    foreach ($items as $item) {
      $pathway->addItem($item['title'], $item['link']);
    }

    return true;
  }

  protected function setTitle()
  {
    if (isset($this->item)) {
      if ($this->item->{$this->id}) {
        JToolBarHelper::title(FactoryText::sprintf('view_title_edit_' . $this->getName(), $this->item->{$this->title}, $this->item->{$this->id}));
      } else {
        JToolBarHelper::title(FactoryText::_('view_title_new_' . $this->getName()));
      }
    } else {
      JToolBarHelper::title(FactoryText::_('view_title_' . $this->getName()));
    }

    return true;
  }
}
