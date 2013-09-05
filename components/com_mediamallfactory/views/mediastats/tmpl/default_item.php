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
    <input type="checkbox" name="batch[]" id="batch_<?php echo $this->item->id; ?>" value="<?php echo $this->item->id; ?>" />
  </td>

  <td>
    <a href="<?php echo FactoryRoute::view('media&media_id='.$this->item->id); ?>"><?php echo $this->item->title; ?></a>
  </td>

  <td class="center" style="vertical-align: top;">
    <?php echo JHtml::_('Factory.link', 'mediacomments&media_id='.$this->item->id, $this->item->unread, 'view', 'class="factory-button-text button-ballon hasTip" title="'.FactoryText::_('mediastats_link_messages_tip_title').'::'.FactoryText::_('mediastats_link_messages_tip_text').'"'); ?>

    <?php if ($this->editOwnMedia): ?>
      <?php echo JHtml::_('Factory.link', 'edit&media_id='.$this->item->id, '', 'view', 'class="factory-button button-document-pencil hasTip" title="'.FactoryText::_('mediastats_link_edit_tip_title').'::'.FactoryText::_('mediastats_link_edit_tip_text').'"'); ?>
    <?php endif; ?>

    <?php echo JHtml::_('Factory.link', 'medialog&media_id='.$this->item->id, '', 'view', 'class="factory-button button-application-list hasTip" title="'.FactoryText::_('mediastats_link_log_tip_title').'::'.FactoryText::_('mediastats_link_log_tip_text').'"'); ?>
  </td>

  <td class="center">
    <?php echo JHtml::_('Factory.currency', $this->item->amount); ?>
  </td>

  <td class="center">
    <?php if ($this->item->sales): ?>
      <a href="<?php echo FactoryRoute::view('historysales&filter[media]=' . $this->item->id); ?>"><?php echo $this->item->sales; ?></a>
    <?php else: ?>
      <?php echo $this->item->sales; ?>
    <?php endif; ?>
  </td>

<!--  <td>--><?php //echo $this->item->type; ?><!--</td>-->

  <td>
    <?php echo JHtml::_('MediaMallFactoryMedia.published', $this->item->published); ?>
  </td>

  <td>
    <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
  </td>
</tr>
