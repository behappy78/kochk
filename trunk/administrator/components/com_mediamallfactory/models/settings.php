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

class MediaMallFactoryBackendModelSettings extends JModel
{
  protected $form_name;

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->form_name = JFactory::getApplication()->input->getCmd('form', 'config');
  }

  public function getForm($loadData = true)
  {
    FactoryForm::addFormPath(FactoryApplication::getInstance()->getPath('component_administrator'));
    FactoryForm::addFieldPath(FactoryApplication::getInstance()->getPath('component_site').DS.'models'.DS.'fields');

		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array(
      'control' => 'config',
    ), true, '/config');

    if ($loadData) {
      $data = $this->loadFormData();
    } else {
      $data = array();
    }

    $form->bind($data);

		return $form;
  }

  public function save($data)
  {
    // Initialise variables.
    $option = FactoryApplication::getInstance()->getOption();
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

    // Save the rules.
	  if (isset($data['permissions']['permissions']['rules'])) {
	    jimport('joomla.access.rules');
	    $rules = new JRules($data['permissions']['permissions']['rules']);
	    $asset = JTable::getInstance('asset');

	    if (!$asset->loadByName($option)) {
	      $root	= JTable::getInstance('asset');
	      $root->loadByName('root.1');
	      $asset->name  = $this->getOption();
	      $asset->title = $this->getOption();
	      $asset->setLocation($root->id, 'last-child');
	    }

	    $asset->rules = (string)$rules;

	    if (!$asset->check() || !$asset->store()) {
	      $this->setError($asset->getError());
	      return false;
	    }

	    unset($data['permissions']);
	  }

	  // Save component settings.
	  $extension = JTable::getInstance('Extension');
	  $id        = $extension->find(array('element' => $option, 'type' => 'component'));
	  $settings  = JComponentHelper::getParams($option);

	  $extension->load($id);
	  $extension->bind(array('params' => $this->mergeArrays($settings->toArray(), $data)));

    if (!$extension->store()) {
      $this->setError($extension->getError());
      return false;
    }

    $this->cleanCache('_system');

    return true;
  }

  protected function loadFormData()
  {
    $data = FactoryApplication::getInstance()->getParams();

    return $data;
  }

  protected function mergeArrays()
  {
    $arrays = func_get_args();
    $base = array_shift($arrays);

    foreach ($arrays as $array) {
      reset($base); //important
      while (list($key, $value) = @each($array)) {
        if (is_array($value) && @is_array($base[$key])) {
          $base[$key] = $this->mergeArrays($base[$key], $value);
        } else {
          $base[$key] = $value;
        }
      }
    }

    return $base;
  }
}
