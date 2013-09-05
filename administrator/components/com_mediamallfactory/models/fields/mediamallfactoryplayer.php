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

class JFormFieldMediaMallFactoryPlayer extends JFormFieldList
{
  public $type = 'MediaMallFactoryPlayer';

  protected function getOptions()
  {
    jimport('joomla.filesystem.folder');

    $options = array();
    $players = JFolder::files(FactoryApplication::getInstance()->getPath('players'), 'config.xml', true, true);
    foreach ($players as $config) {
      $xml = JFactory::getXML($config);

      $title = (string)$xml->title;

      if ($xml->files) {
        $array = array();

        foreach ($xml->files->file as $file) {
          $array[] = (string)$file->attributes()->extension;
        }

        $title .= ' (' . implode(', ', $array) . ')';
      }

      $options[(string)$xml->name] = $title;
    }

    return $options;
  }
}
