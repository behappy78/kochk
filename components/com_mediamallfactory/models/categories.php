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

class MediaMallFactoryFrontendModelCategories extends JModel
{
  public function getItems()
  {
    /* @var $item JCategoryNode */
    $item = $this->getItem();
    $items = $item->getChildren();

    $count = $this->getCategoryMediaCount();

    foreach ($items as &$item) {
      $item->params = new JRegistry($item->params);

      if (isset($count[$item->id])) {
        $item->params->set('media_files', $count[$item->id]->count);
      }

      if ($item->params->get('thumbnail.current')) {
        $item->params->set('thumbnail.current', JURI::root().'components/com_mediamallfactory/storage/thumbnails/'.$item->params->get('thumbnail.current'));
      }
    }

    return $items;
  }

  public function getItem()
  {
    static $items = array();

    $category_id = JFactory::getApplication()->input->getInt('category_id', 0);
    $option      = JFactory::getApplication()->input->getCmd('option', '');
    $hash        = md5($option.$category_id);

    if (!isset($items[$hash])) {
      $categories = JCategories::getInstance(FactoryApplication::getInstance()->getComponent());

      $items[$hash] = $categories->get($category_id);

      if (!$items[$hash]) {
        throw new Exception(FactoryText::sprintf('category_not_found', $category_id), 404);
      }

      $items[$hash]->params = new JRegistry($items[$hash]->params);

      // Set media count for category.
      $count = $this->getCategoryMediaCount();
      if (isset($count[$category_id])) {
        $items[$hash]->params->set('media_files', $count[$category_id]->count);
      }

      // Get purchase category value.
      $category_sale = FactoryApplication::getInstance()->getParam('general.global.category_sale', 0);
      if ($category_sale) {
        $items[$hash]->params->set('purchase_cost', $this->getCategoryCost($category_id));
      } else {
        $items[$hash]->params->set('purchase_cost', 0);
      }

      if ($items[$hash]->params->get('thumbnail.current')) {
        $items[$hash]->params->set('thumbnail.current', JURI::root().'components/com_mediamallfactory/storage/thumbnails/'.$items[$hash]->params->get('thumbnail.current'));
      }
    }

    return $items[$hash];
  }

  public function getPathway()
  {
    $array = array();
    $item  = $this->getItem();

    while ($item && 'root' != $item->id) {
      $array[] = array(
        'title' => $item->title,
        'link'  => FactoryRoute::view('categories&category_id=' . $item->id));
      $item = $item->getParent();
    }

    if (!$array) {
      return array();
    }

    krsort($array);

    return $array;
  }

  public function getThumbnailWidth()
  {
    return FactoryApplication::getInstance()->getParam('general.thumbnails.category_width', 64);
  }

  protected function getCategoryMediaCount()
  {
    static $count = null;

    if (is_null($count)) {
      $dbo = $this->getDbo();
      $query = $dbo->getQuery(true)
        ->select('COUNT(m.id) AS count, m.category_id')
        ->from('#__mediamallfactory_media m')
        ->where('m.published = ' . $dbo->quote(1))
        ->group('m.category_id');

      $query->leftJoin('#__categories c ON c.id = m.category_id')
        ->where('c.published = ' . $dbo->quote(1))
        ->where('c.id IS NOT NULL');

      $query->leftJoin('#__mediamallfactory_types t ON t.id = m.type_id')
        ->where('t.published = ' . $dbo->quote(1))
        ->where('t.id IS NOT NULL');

      $count = $dbo->setQuery($query)
        ->loadObjectList('category_id');
    }

    return $count;
  }

  protected function getCategoryCost($category_id)
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('SUM(m.cost_media) AS cost')
      ->from('#__mediamallfactory_media m')
      ->where('m.category_id = ' . $dbo->quote($category_id))
      ->where('m.user_id <> ' . $dbo->quote(JFactory::getUser()->id))
      ->where('m.cost_media <> 0');

    $query->leftJoin('#__mediamallfactory_purchases p ON p.media_id = m.id AND p.active = ' . $dbo->quote(1))
      ->where('p.id IS NULL');

    $query->leftJoin('#__categories c ON c.id = m.category_id')
      ->where('c.published = ' . $dbo->quote(1))
      ->where('c.id IS NOT NULL');

    $query->leftJoin('#__mediamallfactory_types t ON t.id = m.type_id')
      ->where('t.published = ' . $dbo->quote(1))
      ->where('t.id IS NOT NULL');

    $result = $dbo->setQuery($query)
      ->loadResult();

    return $result;
  }
}

jimport('joomla.application.categories');

class MediaMallFactoryCategories extends JCategories
{
	public function __construct($options = array())
	{
		$options['table']     = '#__content';
		$options['extension'] = JFactory::getApplication()->input->getCmd('option', '');

    parent::__construct($options);
	}
}
