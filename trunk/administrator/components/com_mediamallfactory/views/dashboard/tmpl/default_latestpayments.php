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

<div class="box" id="portlet_latestpayments">
  <div class="header">
    <?php echo FactoryText::_('dashboard_box_latest_payments_header'); ?>
    <span>(<a href="<?php echo FactoryRoute::view('payments&reset_filters=1&filter_order=created_at&filter_order_Dir=desc"'); ?>"><?php echo FactoryText::_('dashboard_latest_media_view_all'); ?></a>)</span>
    <div style="display: none;" class="factory-button button-minus minimize"></div>
  </div>
  <div class="content">

    <?php if ($this->latestPayments): ?>
      <table>
        <thead>
          <tr>
            <th><?php echo FactoryText::_('dashboard_latest_orders_list_title_label'); ?></th>
            <th width="70px" style="text-align: right;"><?php echo FactoryText::_('dashboard_latest_orders_list_amount_label'); ?></th>
            <th width="100px"><?php echo FactoryText::_('dashboard_latest_orders_list_gateway_label'); ?></th>
<!--            <th width="70px">--><?php //echo FactoryText::_('dashboard_latest_orders_list_username_label'); ?><!--</th>-->
            <th width="70px"><?php echo FactoryText::_('dashboard_latest_orders_list_status_label'); ?></th>
            <th width="110px"><?php echo FactoryText::_('dashboard_latest_orders_list_date_label'); ?></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($this->latestPayments as $this->i => $this->item): ?>
            <tr class="<?php echo $this->i % 2 ? '' : 'even'; ?>">
              <td><a href="<?php echo FactoryRoute::view('payment&id=' . $this->item->id); ?>"><?php echo $this->item->refnumber; ?></a></td>
              <td class="right"><?php echo $this->item->amount; ?> <?php echo $this->item->currency; ?></td>
              <td><a href="<?php echo FactoryRoute::view('gateway&id=' . $this->item->gateway_id); ?>"><?php echo $this->item->gateway_title; ?></a></td>
<!--              <td><a href="#">--><?php //echo $this->item->username; ?><!--</a></td>-->
              <td><?php echo JHtml::_('MediaMallFactoryOrders.statusBadge', $this->item->status); ?></td>
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
