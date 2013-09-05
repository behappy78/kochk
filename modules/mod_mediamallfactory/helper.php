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

class modMediaMallHelper
{
  public static function isComponentInstalled($element)
  {
    $extension = JTable::getInstance('Extension');
    $result = $extension->load(array('element' => $element, 'type' => 'component'));

    return $result;
  }

  public static function getList($params)
  {
    $dbo   = JFactory::getDbo();
    $query = self::getListQuery();

    $sort = array(
      'latest'     => 'm.created_at',
      'rated'      => 'm.rating',
      'downloaded' => 'm.downloads',
    );

    $cost = $params->get('cost', '');
    if ('' != $cost) {
      if ($cost) {
        $query->where('m.cost_media > ' . $dbo->quote(0));
      } else {
        $query->where('m.cost_media = ' . $dbo->quote(0));
      }
    }

    $query->order($sort[$params->get('mode', 'latest')] . ' DESC');

    $results = $dbo->setQuery($query, 0, $params->get('limit', 5))
      ->loadObjectList();

    return $results;
  }

  public static function getListQuery()
  {
    $dbo   = JFactory::getDbo();
    $query = $dbo->getQuery(true)
      ->select('m.id, m.title, m.rating, m.created_at, m.downloads')
      ->from('#__mediamallfactory_media m')
      ->where('m.published = ' . $dbo->quote(1));

    return $query;
  }
}
