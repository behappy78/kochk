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

defined('_JEXEC') or die; ?>

<tr class="<?php echo $this->i % 2 ? '' : 'even'; ?>">
  <td>
    <a href="<?php echo FactoryRoute::view('contacts&contact_id=' . $this->item->id); ?>"><?php echo $this->item->media_title; ?></a><?php echo JHtml::_('MediaMallFactoryMedia.unread', $this->item->pending); ?>
  </td>

  <td>
    <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
  </td>
</tr>
