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

class JFormFieldMediaMallFactorySysInfo extends JFormField
{
  public $type = 'MediaMallFactorySysInfo';

  protected function getInput()
  {
    $html = array();

    $html[] = $this->getInfo($this->fieldname);

    return implode("\n", $html);
  }

  protected function getInfo($field)
  {
    switch ($field) {
      case 'error_reporting':
        $config	= new JConfig();
		    $data	= JArrayHelper::fromObject($config);

        $language = JFactory::getLanguage();
        $language->load('com_config', JPATH_ADMINISTRATOR);

        $options = array(
          'default'     => JText::_('COM_CONFIG_FIELD_VALUE_SYSTEM_DEFAULT'),
			    'none'        => JText::_('COM_CONFIG_FIELD_VALUE_NONE'),
			    'simple'      => JText::_('COM_CONFIG_FIELD_VALUE_SIMPLE'),
			    'maximum'     => JText::_('COM_CONFIG_FIELD_VALUE_MAXIMUM'),
			    'development' => JText::_('COM_CONFIG_FIELD_VALUE_DEVELOPMENT'),
        );

        $html = $options[$data['error_reporting']];
        break;

      case 'site_locale_time':
        $html = JHTML::_('date', 'now', 'l, d F Y, H:i');
        break;

      case 'display_errors':
        $html = ini_get('display_errors') ? JText::_('JYES') : JText::_('JNO');
        break;

      case 'file_uploads':
        $html = ini_get('file_uploads') ? JText::_('JYES') : JText::_('JNO');
        break;

      case 'max_upload_size':
        $html = ini_get('upload_max_filesize');
        break;

      case 'gmt_time':
        $html = gmdate('l, d F Y H:i', time());
        break;

      default:
        $html = $field;
        break;
    }

    return $html;
  }
}
