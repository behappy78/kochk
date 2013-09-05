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

JFormHelper::loadFieldType('List');

class JFormFieldMediaMallFactoryNotificationType extends JFormFieldList
{
  public $type = 'MediaMallFactoryNotificationType';

  protected function getOptions()
  {
    $model = JModel::getInstance('Notifications', 'MediaMallFactoryBackendModel');

    $options = $model->getFilterType();

    array_unshift($options, array('value' => '', 'text' => ''));

    return $options;
  }
}
