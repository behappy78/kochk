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

class MediaMallFactoryBackendModelMessages extends JModel
{
  protected $form_name = 'adminmessage';

  public function getForm()
  {
    // Get the form.
    $path = FactoryApplication::getInstance()->getPath('component_site').DS.'models';

    JForm::addFormPath($path.DS.'forms');
		JForm::addFieldPath($path.DS.'fields');
		JForm::addRulePath($path.DS.'fields');

    /* @var $form JForm */
  	$form = JForm::getInstance($this->form_name, $this->form_name, array('control' => $this->form_name));

    $language = JFactory::getLanguage();
    $language->load(FactoryApplication::getInstance()->getOption(), JPATH_SITE);

		return $form;
  }

  public function getItem()
  {
    static $items;

    $input   = JFactory::getApplication()->input;
    $type    = $input->getCmd('type', '');
    $item_id = $input->getCmd('item_id', 0);
    $hash    = md5($type.$item_id);

    if (!isset($items[$hash])) {
      if ('media' == $type) {
        $table = FactoryTable::getInstance('Media');
      } else {
        $table = FactoryTable::getInstance('PaymentRequest');
      }

      $table->load($item_id);

      $items[$hash] = $table;
    }

    return $items[$hash];
  }

  public function getItems()
  {
    $input   = JFactory::getApplication()->input;
    $type    = $input->getCmd('type', '');
    $item_id = $input->getCmd('item_id', 0);

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('m.*')
      ->from('#__mediamallfactory_admin_messages m')
      ->where('m.type = ' . $dbo->quote($type))
      ->where('m.item_id = ' . $dbo->quote($item_id))
      ->order('m.created_at DESC');

    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = m.user_id');

    $items = $dbo->setQuery($query)
      ->loadObjectList();

    $this->markAsRead($items);

    return $items;
  }

  public function getTable($name = 'AdminMessage', $prefix = 'MediaMallFactoryTable', $options = array())
  {
    return parent::getTable($name, $prefix, $options);
  }

  protected function markAsRead($items, $is_admin = true)
  {
    $array = array();
    foreach ($items as $item) {
      if ($item->pending && (int)!$is_admin == $item->is_admin) {
        $array[] = $item->id;
      }
    }

    if (!$array) {
      return true;
    }

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->update('#__mediamallfactory_admin_messages')
      ->set('pending = ' . $dbo->quote(0))
      ->where('id IN ('.implode(',', $array).')');

    return $dbo->setQuery($query)
      ->query();
  }
}
