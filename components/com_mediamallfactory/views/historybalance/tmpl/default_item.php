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
    <?php echo FactoryText::_('historybalance_filter_type_' . $this->item->type); ?>
  </td>

  <td class="center">
    <?php echo JHtml::_('Factory.currency', $this->item->sign * $this->item->amount); ?>
  </td>

  <td>
    <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
  </td>

  <td>
    <?php if ($this->item->media_id): ?>
      <?php echo JHtml::_('MediaMallFactoryMedia.mediaLink', $this->item->media_id, $this->item->media_title); ?>
    <?php endif; ?>
  </td>
</tr>
