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

class MediaMallFactoryBackendModelGateway extends JModel
{
  protected $form_name = 'gateway';

  public function getForm($loadData = true)
  {
    $item = $this->getItem();

    FactoryForm::addFieldPath(FactoryApplication::getInstance()->getPath('component_site').DS.'models'.DS.'fields');
    FactoryForm::addFormPath(FactoryApplication::getInstance()->getPath('payment_gateways').DS.$item->element);

    FactoryApplication::getInstance()->loadLanguage('site', $item->element);

		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array(
      'control' => $this->form_name,
    ));

    $form->loadFile($item->element);

    if ($loadData) {
      $data = $this->loadFormData();
    } else {
      $data = array();
    }

    $form->bind($data);

		return $form;
  }

  public function publish($batch, $state = 1)
  {
    JArrayHelper::toInteger($batch);

    if (!$batch) {
      $this->setError(FactoryText::_('list_empty'));
      return false;
    }

    $table = FactoryTable::getInstance('PaymentGateway');
    foreach ($batch as $id) {
      $table->load($id);

      if (!$table->publish($state)) {
        $this->setError($table->getError());
        return false;
      }
    }

    return true;
  }

  public function reorder($pks, $delta = 0)
	{
		// Initialise variables.
		$table = FactoryTable::getInstance('PaymentGateway');
		$pks = (array) $pks;
		$result = true;

		foreach ($pks as $i => $pk) {
			$table->reset();

			if ($table->load($pk)) {
				$where = array();

				if (!$table->move($delta, $where)) {
					$this->setError($table->getError());
					unset($pks[$i]);
					$result = false;
				}
			} else {
				$this->setError($table->getError());
				unset($pks[$i]);
				$result = false;
			}
		}

		return $result;
	}

  public function saveorder($pks = null, $order = null)
	{
		// Initialise variables.
		$table = FactoryTable::getInstance('PaymentGateway');
		$conditions = array();

		if (empty($pks)) {
      $this->setError(FactoryText::_('list_empty'));
			return false;
		}

		// Update ordering values
		foreach ($pks as $i => $pk) {
			$table->load((int) $pk);

			if ($table->ordering != $order[$i]) {
				$table->ordering = $order[$i];

				if (!$table->store()) {
					$this->setError($table->getError());
					return false;
				}

				// Remember to reorder within position and client_id
				$condition = array();
				$found = false;

				foreach ($conditions as $cond) {
					if ($cond[1] == $condition) {
						$found = true;
						break;
					}
				}

				if (!$found) {
					$key = $table->getKeyName();
					$conditions[] = array($table->$key, $condition);
				}
			}
		}

		// Execute reorder for each category.
		foreach ($conditions as $cond) {
			$table->load($cond[0]);
			$table->reorder($cond[1]);
		}

		return true;
	}

  public function getItem($pk = null)
  {
    static $items = array();
    $pk = is_null($pk) ? JFactory::getApplication()->input->get->getInt('id', 0) : $pk;

    if (!isset($items[$pk])) {
      $table = FactoryTable::getInstance('PaymentGateway');
      $table->load($pk);

      $items[$pk] = $table;
    }

    return $items[$pk];
  }

  public function save($data)
  {
    // Initialise variables.
    $form   = $this->getForm(false);
    $data   = $form->filter($data);
    $return = $form->validate($data);

    // Check if form is valid.
    if (!$return) {
      foreach ($form->getErrors() as $message) {
				$this->setError(JText::_($message));
			}

      return false;
    }

    $table = $this->getItem($data['id']);

    $this->setState('id', $data['id']);

    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    $this->setState('id', $table->id);

    return true;
  }

  protected function loadFormData()
  {
    // Check the session for previously entered form data.
    $name    = $this->getName();
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.'.$name.'.data';

    $data = JFactory::getApplication()->getUserState($context, array());
    JFactory::getApplication()->setUserState($context, array());

    if (!$data) {
      $data = $this->getItem();
    }

    if (isset($data->params) && $data->params instanceof JRegistry) {
      $data->params = $data->params->toArray();
    }

    return $data;
  }
}
