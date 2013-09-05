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

class MediaMallFactoryEventComments extends JEvent
{
  public function onMediaMallFactoryMediaDelete($id)
  {
    $dbo = JFactory::getDbo();
    $query = $dbo->getQuery(true)
      ->select('c.id')
      ->from('#__mediamallfactory_comments c')
      ->where('c.media_id = ' . $dbo->quote($id));
    $items = $dbo->setQuery($query)
      ->loadResultArray();

    $table = FactoryTable::getInstance('Comment');
    foreach ($items as $id) {
      $table->delete($id);
    }

    return true;
  }

  public function onMediaMallFactoryCommentDelete($id)
  {
    $dbo = JFactory::getDbo();
    $query = $dbo->getQuery(true)
      ->select('v.id')
      ->from('#__mediamallfactory_comments_votes v')
      ->where('v.comment_id = ' . $dbo->quote($id));
    $items = $dbo->setQuery($query)
      ->loadResultArray();

    $table = FactoryTable::getInstance('CommentVote');
    foreach ($items as $id) {
      $table->delete($id);
    }

    return true;
  }
}
