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
    <a href="<?php echo FactoryRoute::view('request&id=' . $this->item->id); ?>"><?php echo $this->item->username; ?></a>
	</td>

  <td class="center">
    <span class="factory-badge <?php echo $this->item->messages ? 'badge-important' : ''; ?>"><?php echo $this->item->messages; ?></span>
  </td>

  <td class="right">
    <?php echo $this->item->amount; ?>
  </td>

  <td class="center">
    <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
  </td>

  <td class="center">
    <?php echo JHtml::_('MediaMallFactoryRequests.status', $this->item->status); ?>
  </td>
</tr>
