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
    <a href="<?php echo FactoryRoute::view('payment&id=' . $this->item->id); ?>"><?php echo $this->item->refnumber; ?></a>
	</td>

  <td class="right">
    <?php echo $this->item->amount; ?> <?php echo $this->item->currency; ?>
  </td>

  <td class="center">
    <a href="<?php echo FactoryRoute::view('order&id=' . $this->item->order_id); ?>"><?php echo $this->item->order_id; ?></a>
  </td>

  <td>
    <a href="#"><?php echo $this->item->username; ?></a>
  </td>

  <td>
    <a href="#"><?php echo $this->item->gateway_title; ?></a>
  </td>

  <td class="center">
    <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
  </td>

  <td class="center">
    <?php echo JHtml::_('MediaMallFactoryOrders.status', $this->item->status); ?>
  </td>

  <td class="center">
    <?php echo $this->item->id; ?>
  </td>
</tr>
