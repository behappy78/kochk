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

class FactoryRoute
{
  public static function _($url = '', $xhtml = false, $ssl = null)
  {
    $option = FactoryApplication::getInstance()->getOption();
    $url    = 'index.php?option=' . $option . ($url != '' ? '&' . $url : '');

    return JRoute::_($url, $xhtml, $ssl);
  }

  public static function view($view, $xhtml = false, $ssl = null)
  {
    $url = 'view=' . $view;

    return self::_($url, $xhtml, $ssl);
  }

  public static function task($task, $xhtml = false, $ssl = null)
  {
    $url = 'task=' . $task;

    return self::_($url, $xhtml, $ssl);
  }
}

class FactoryText
{
  public static function _($string, $jsSafe = false, $interpretBackSlashes = true, $script = false)
  {
    $original = $string;
    $option   = FactoryApplication::getInstance()->getOption();
    $string   = strtoupper($option . '_' . $string);

    // Check if debugging and language string missing from language file
    if (0 && JFactory::getApplication()->getCfg('debug') && !JFactory::getLanguage()->hasKey($string)) {
      jimport('joomla.filesystem.file');

      // Check if default language file exists and create if not
      $path = JPATH_BASE.DS.'language'.DS.'en-GB'.DS.'en-GB.' . $option . '.ini';
      if (!JFile::exists($path)) {
        $contents = '';
        JFile::write($path, $contents);
      }

      // Add new language string and save language file
      $contents = rtrim(JFile::read($path), PHP_EOL) . PHP_EOL . $string . '="' . str_replace('_', ' ', $original) . '"';
      JFile::write($path, $contents);
    }

    if (0) {
      return $original;
    }

    return JText::_($string, $jsSafe, $interpretBackSlashes, $script);
  }

  public static function sprintf()
  {
    $args    = func_get_args();
    $option  = FactoryApplication::getInstance()->getOption();
    $args[0] = strtoupper($option . '_' . $args[0]);

    return call_user_func_array(array('JText', 'sprintf'), $args);
  }

  public static function script($string = null, $jsSafe = false, $interpretBackSlashes = true)
  {
    $option = JRequest::getCmd('option');
    $string = strtoupper($option . '_' . $string);

    return JText::script($string, $jsSafe, $interpretBackSlashes);
  }

  public static function plural($string, $n)
  {
    $option = FactoryApplication::getInstance()->getOption();
    $string = strtoupper($option . '_' . $string);

    return JText::plural($string, $n);
  }
}

class FactoryHtml
{
  static $framework_loaded = false;

  public static function _($key)
	{
	}

  public static function script($file, $framework = true, $relative = false, $path_only = false, $detect_browser = true, $detect_debug = true)
  {
    if ($framework && !self::$framework_loaded) {
      self::script('jquery', false);
      self::script('jquery.noconflict', false);

      self::$framework_loaded = true;

      $document = JFactory::getDocument();
      $document->addScriptDeclaration('jQueryFactory(document).ready(function ($) { $.ajaxPrefilter(function(options, originalOptions, jqXHR) { options.url = "' . JURI::root() . '" + options.url; }); });');
    }

    $file = self::parsePath($file);

    JHtml::script($file, $framework, $relative, $path_only, $detect_browser, $detect_debug);
  }

  public static function stylesheet($file, $attribs = array(), $relative = false, $path_only = false, $detect_browser = true, $detect_debug = true)
  {
    $file = self::parsePath($file, 'css');

    JHtml::stylesheet($file, $attribs, $relative, $path_only, $detect_browser, $detect_debug);
  }

  protected static function parsePath($file, $type = 'js')
  {
    $path  = array();
    $parts = explode('/', $file);

    $path[] = 'components';
    $path[] = FactoryApplication::getInstance()->getOption();

    if (isset($parts[0]) && 'admin' == $parts[0]) {
      array_unshift($path, 'administrator');
      unset($parts[0]);
      $parts = array_values($parts);
    }

    $path[] = 'assets';
    $path[] = $type;

    $count = count($parts);
    foreach ($parts as $i => $part) {
      if ($i + 1 == $count) {
        $path[] = $part . '.' . $type;
      } else {
        $path[] = $part;
      }
    }

    return implode('/', $path);
  }
}

class FactoryMailer
{
  protected $mailer;

  public function __construct()
  {
    $this->mailer = JFactory::getMailer();
  }

  public static function getInstance()
  {
    static $instance = null;

    if (is_null($instance)) {
      $instance = new self();
    }

    return $instance;
  }

  public function send($type, $receiverId, $variables = array(), $isHtml = true)
  {
    // Initialise variables.
    $receiver         = JFactory::getUser($receiverId);
    $app              = JFactory::getApplication();
    $receiverLanguage = $receiver->getParam('language', JComponentHelper::getParams('com_languages')->get('site'));
    $receiverEmail    = $receiver->email;
    $options          = $this->getNotificationOptions($type);
    $notification     = $this->getNotification($type, $receiverLanguage);

    // Check if notification was found.
    if (!$notification) {
      return false;
    }

    // Prepare subject and body.
    $subject = $this->parseVariables($notification->subject, $options, $variables);
    $body    = $this->parseVariables($notification->body,    $options, $variables);

    // Send mail.
    $this->mailer->setSubject($subject);
    $this->mailer->setBody($body);
    $this->mailer->addRecipient($receiverEmail);
    $this->mailer->setSender(array($app->getCfg('mailfrom'), $app->getCfg('fromname')));
    $this->mailer->isHtml($isHtml);

    if (!$this->mailer->send()) {
      return false;
    }

    return true;
  }

  protected function getNotificationOptions($type)
  {
    $options = array();
    $xml = JFactory::getXML(FactoryApplication::getInstance()->getPath('component_administrator').DS.'notifications.xml');
    $notification = $xml->xpath('//notification[@type="'.$type.'"]');

    if (!$notification) {
      return $options;
    }

    foreach ($notification[0]->option as $option) {
      $options[] = (string)$option;
    }

    return $options;
  }

  protected function getNotification($type, $receiverLanguage)
  {
    $dbo = JFactory::getDbo();
    $query = $dbo->getQuery(true)
      ->select('n.*')
      ->from('#__mediamallfactory_notifications n')
      ->where('n.type = ' . $dbo->quote($type))
      ->where('n.published = ' . $dbo->quote(1))
      ->where('(n.lang_code = ' . $dbo->quote($receiverLanguage) . ' OR n.lang_code = ' . $dbo->quote('*') . ')');
    $notifications = $dbo->setQuery($query)
      ->loadObjectList('lang_code');

    if (!$notifications) {
      return false;
    }

    return isset($notifications[$receiverLanguage]) ? $notifications[$receiverLanguage] : $notifications['*'];
  }

  protected function parseVariables($string, $search, $replace)
  {
    // Prepare variables.
    foreach ($search as &$variable) {
      $variable = '%%' . $variable . '%%';
    }

    // Replace variables.
    $string = str_replace($search, $replace, $string);

    // Replace image sources.
    $string = str_replace('src="', 'src="' . JURI::root(), $string);

    return $string;
  }
}

class FactoryForm extends JForm
{
  public function loadFile($file, $reset = true, $xpath = false)
  {
    if (!parent::loadFile($file, $reset, $xpath)) {
      return false;
    }

    $this->setLabels();

    return true;
  }

  public static function getInstance($name, $data = null, $options = array(), $replace = true, $xpath = false)
	{
    self::addPaths($options);

		// Reference to array with form instances
		$forms = &self::$forms;

		// Only instantiate the form if it does not already exist.
		if (!isset($forms[$name])) {
			$data = trim($data);

			if (empty($data)) {
				throw new Exception(JText::_('JLIB_FORM_ERROR_NO_DATA'));
			}

			// Instantiate the form.
			$forms[$name] = new self($name, $options);

			// Load the data.
			if (substr(trim($data), 0, 1) == '<') {
				if ($forms[$name]->load($data, $replace, $xpath) == false) {
					throw new Exception(JText::_('JLIB_FORM_ERROR_XML_FILE_DID_NOT_LOAD'));

					return false;
				}
			} else {
				if ($forms[$name]->loadFile($data, $replace, $xpath) == false) {
					throw new Exception(JText::_('JLIB_FORM_ERROR_XML_FILE_DID_NOT_LOAD'));

					return false;
				}
			}
		}

		return $forms[$name];
	}

  public function render($tmpl = 'template', $path = null)
  {
    jimport('joomla.filesystem.file');

    if (is_null($path)) {
      $path = FactoryApplication::getInstance()->getPath('factory').DS.'form';
    }

    $template = $path.DS.$tmpl.'.php';
    if (!JFile::exists($template)) {
      throw new Exception(FactoryText::_('form_template_file_not_found'), 500);
    }

    ob_start();
    include $template;
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
  }

  public function renderFieldset($name, $tmpl = 'fieldset', $path = null)
  {
    jimport('joomla.filesystem.file');

    if (is_null($path)) {
      $path = FactoryApplication::getInstance()->getPath('factory').DS.'form';
    }

    $template = $path.DS.$tmpl.'.php';
    if (!JFile::exists($template)) {
      throw new Exception(FactoryText::_('form_template_file_not_found'), 500);
    }

    $this->fieldset = $name;

    ob_start();
    include $template;
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
  }

  protected function renderHiddenFields()
  {
    $html = array();

    $elements = $this->xml->xpath('//fieldset/field[@type="hidden"]');

    foreach ($elements as $element) {
      if ($field = $this->loadField($element))
			{
        $html[] = $field->input;
			}
    }

    $html[] = JHtml::_('form.token');

    return implode("\n", $html);
  }

  protected function setLabels()
  {
    $admin = JFactory::getApplication()->isAdmin();

    foreach ($this->getFieldsets() as $fieldset) {
      // Set the fieldset label.
      if ('' == $fieldset->label) {
        $tmp = $this->xml->xpath('/form/fieldset[@name="' . $fieldset->name . '"]');
        $tmp[0]['label'] = FactoryText::_('form_'.$this->name.'_fieldset_'.$fieldset->name.'_label');
      }

      foreach ($this->getFieldset($fieldset->name) as $field) {
        // Check if field is only for backend.
        if (!$admin && 'true' === $this->getFieldAttribute($field->fieldname, 'adminonly', '', $field->group)) {
          $this->removeField($field->fieldname, $field->group);
          continue;
        }

        // Set field label.
        if ('' == $this->getFieldAttribute($field->fieldname, 'label', '', $field->group)) {
          $this->setFieldAttribute(
            $field->fieldname,
            'label',
            FactoryText::_('form_'.$this->name.'_'.$field->fieldname.'_label'),
            $field->group);
        }

        // Set field description.
        if ('' == $this->getFieldAttribute($field->fieldname, 'description', '', $field->group)) {
          $this->setFieldAttribute(
            $field->fieldname,
            'description',
            FactoryText::_('form_'.$this->name.'_'.$field->fieldname.'_desc'),
            $field->group);
        }
      }
    }

    return true;
  }

  protected static function addPaths($options)
  {
    $location = isset($options['path_location']) ? '_'. $options['path_location'] : '';
    $base = FactoryApplication::getInstance()->getPath('component'.$location).DS.'models';

    self::addFormPath($base.DS.'forms');
    self::addFieldPath($base.DS.'fields');
    self::addRulePath($base.DS.'rules');

    return true;
  }

  public static function addFieldPath($location = 'site')
	{
    if (in_array($location, array('site', 'admin'))) {
      $location = FactoryApplication::getInstance()->getPath('component_' . $location).DS.'models'.DS.'fields';
    }

    return parent::addFieldPath($location);
	}

  protected function getConfigTabs()
  {
    $sets = array();
    $fieldsets = $this->xml->xpath('//fieldset');

    foreach ($fieldsets as $fieldset) {
      $fields = $this->xml->xpath('//fieldset[@name="'.(string)$fieldset->attributes()->name.'"] //fields //fields');

      foreach ($fields as $field) {
        $sets[(string)$fieldset->attributes()->name][(string)$field->attributes()->side][] = (string)$field->attributes()->name;
      }
    }

    return $sets;
  }

  protected function getConfigFields($fieldset, $name)
  {
    $array = array();
    $fieldsets = $this->xml->xpath('//fieldset[@name="'.$fieldset.'"] //fields //fields[@name="'.$name.'"]');

    if (!$fieldsets) {
      return $array;
    }

    $temp = $fieldsets[0]->xpath('ancestor::fields/@name');
    $set = (string)$temp[0];

    foreach ($fieldsets[0]->field as $element) {
      $group = $set.'.'.$name;

      if ($field = $this->loadField($element, $group)) {
				$array[$field->id] = $field;
			}
    }

    return $array;
  }

  public function removeFieldset($fieldset)
  {
    // Make sure there is a valid JForm XML document.
		if (!($this->xml instanceof SimpleXMLElement)) {
			return false;
		}

		// Get the fields elements for a given group.
		$elements = $this->xml->xpath('//fieldset[@name="'.$fieldset.'"]');
		foreach ($elements as &$element) {
			$dom = dom_import_simplexml($element);
			$dom->parentNode->removeChild($dom);
		}

		return true;
  }
  public function getFieldsset($fieldset)
  {
    // Make sure there is a valid JForm XML document.
		if (!($this->xml instanceof SimpleXMLElement)) {
			return false;
		}

		// Get the fields elements for a given group.
		$elements = $this->xml->xpath('//fieldset[@name="'.$fieldset.'"]');
    	return $elements;
  }  
}
