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

class MediaMallFactoryEventMessages extends JEvent
{
  public function onMediaMallFactoryMediaDelete($id)
  {
    $dbo = JFactory::getDbo();
    $query = $dbo->getQuery(true)
      ->delete()
      ->from('#__mediamallfactory_admin_messages')
      ->where('item_id = ' . $dbo->quote($id))
      ->where('type = ' . $dbo->quote('media'));

    return $dbo->setQuery($query)
      ->query();
  }

  public function onMediaMallFactoryMediaPublish($id, $state, $owner_id)
  {
    $table = FactoryTable::getInstance('AdminMessage');

    $table->type     = 'media';
    $table->item_id  = $id;
    $table->user_id  = JFactory::getUser()->id;
    $table->is_admin = 1;
    $table->message  = $state ? FactoryText::_('media_has_been_published') : FactoryText::_('media_has_been_unpublished');
    $table->owner_id = $owner_id;

    return $table->store();
  }

  public function onMediaMallFactoryCommentStore($media_id)
  {
    $media = FactoryTable::getInstance('Media');
    $media->load($media_id);

    $table = FactoryTable::getInstance('AdminMessage');

    $table->type     = 'media';
    $table->item_id  = $media_id;
    $table->is_admin = 1;
    $table->message  = FactoryText::_('media_new_comment_added');
    $table->owner_id = $media->user_id;

    return $table->store();
  }
}
