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
    <a href="<?php echo FactoryRoute::view('paymentrequestcomments&request_id=' . $this->item->id); ?>"><?php echo FactoryText::sprintf('paymentrequest_item_title', $this->item->id); ?></a><?php if ($this->item->messages): ?><span class="factory-badge"><?php echo $this->item->messages; ?></span><?php endif; ?>
  </td>

  <td class="right">
    <?php echo JHtml::_('Factory.currency', $this->item->amount); ?>
  </td>

  <td>
    <?php echo JHtml::_('MediaMallFactoryPaymentRequest.status', $this->item->status); ?>
  </td>

  <td>
    <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
  </td>

  <td>
    <?php if ($this->item->status != 0): ?>
      <?php echo $this->item->resolved_at; ?>
    <?php endif; ?>
  </td>
</tr>
