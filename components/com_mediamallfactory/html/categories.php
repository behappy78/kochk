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

class JHtmlMediaMallFactoryCategories
{
  public static function subcategories($item)
  {
    /* @var $item JCategoryNode */
    if (!$item->hasChildren()) {
      return '';
    }

    $html = array();

    $html[] = '<div class="subcategories">';
    $html[] = '<b>' . FactoryText::_('categories_subcategories') . ':</b>';

    foreach ($item->getChildren() as $children) {
      $array[] = JHtml::_('Factory.link', 'categories&category_id=' . $children->id, $children->title);
    }

    $html[] = implode(', ', $array);

    $html[] = '</div>';

    return implode("\n", $html);
  }
}
