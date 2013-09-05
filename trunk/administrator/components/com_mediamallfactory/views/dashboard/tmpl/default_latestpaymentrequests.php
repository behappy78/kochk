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

<div class="box" id="portlet_latestpaymentrequests">
  <div class="header">
    <?php echo FactoryText::_('dashboard_box_latest_payment_requests_header'); ?>
    <span>(<a href="<?php echo FactoryRoute::view('requests&reset_filters=1&filter_order=created_at&filter_order_Dir=desc"'); ?>"><?php echo FactoryText::_('dashboard_latest_media_view_all'); ?></a>)</span>
    <div style="display: none;" class="factory-button button-minus minimize"></div>
  </div>
  <div class="content">

    <?php if ($this->latestPaymentRequests): ?>
      <table>
        <thead>
          <tr>
            <th><?php echo FactoryText::_('dashboard_latest_payment_requests_list_username_label'); ?></th>
            <th width="70px" style="text-align: right;"><?php echo FactoryText::_('dashboard_latest_payment_requests_list_amount_label'); ?></th>
            <th width="70px"><?php echo FactoryText::_('dashboard_latest_payment_requests_list_status_label'); ?></th>
            <th width="110px"><?php echo FactoryText::_('dashboard_latest_payment_requests_list_date_label'); ?></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($this->latestPaymentRequests as $this->i => $this->item): ?>
            <tr class="<?php echo $this->i % 2 ? '' : 'even'; ?>">
              <td><a href="<?php echo FactoryRoute::view('request&id=' . $this->item->id); ?>"><?php echo $this->item->username; ?></a></td>
              <td style="text-align: right;"><?php echo JHtml::_('Factory.currency', $this->item->amount); ?></td>
              <td><?php echo JHtml::_('MediaMallFactoryRequests.statusBadge', $this->item->status); ?></td>
              <td><?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p><?php echo FactoryText::_('dashboard_list_no_items'); ?></p>
    <?php endif; ?>

  </div>
</div>
