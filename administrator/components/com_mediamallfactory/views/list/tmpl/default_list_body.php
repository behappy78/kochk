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

<tr class="row<?php echo $this->i % 2; ?>">
  <td class="center">
    <?php echo JHtml::_('grid.id', $this->i, $this->item->id); ?>
  </td>

  <td>
    <a href="<?php echo FactoryRoute::view('media&media_id=' . $this->item->id); ?>"><?php echo $this->item->title; ?></a>
    <p class="smallsub"><span><?php echo JHtml::_('Factory.stripText', $this->item->description, 100, 'media_no_description'); ?></span></p>
	</td>

  <td class="center">
    <span class="factory-badge <?php echo $this->item->messages ? 'badge-important' : ''; ?>"><?php echo $this->item->messages; ?></span>
  </td>

  <td class="center">
    <?php echo JHtml::_('MediaMallFactoryMedia.simpleRating', $this->item->rating); ?>
  </td>

  <td>
    <a href="#"><?php echo $this->item->category_title; ?></a>
  </td>

  <td>
    <a href="#"><?php echo $this->item->type_title; ?></a>
  </td>

  <td>
    <a href="#"><?php echo $this->item->username; ?></a>
  </td>

  <td class="center">
    <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
  </td>

  <td class="center">
    <?php echo JHtml::_('MediaMallFactoryAdmin.published', $this->item->published); ?>
  </td>
</tr>
