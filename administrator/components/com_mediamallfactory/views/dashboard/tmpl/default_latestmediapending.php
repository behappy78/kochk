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

<div class="box" id="portlet_latestmediapending">
  <div class="header">
    <?php echo FactoryText::_('dashboard_box_latest_media_pending_header'); ?>
    <span>(<a href="<?php echo FactoryRoute::view('list&reset_filters=1&filter_published=-1&filter_order=created_at&filter_order_Dir=desc"'); ?>"><?php echo FactoryText::_('dashboard_latest_media_view_all'); ?></a>)</span>
    <div style="display: none;" class="factory-button button-minus minimize"></div>
  </div>
  <div class="content">

    <?php if ($this->latestMediaPending): ?>
      <table>
        <thead>
          <tr>
            <th><?php echo FactoryText::_('dashboard_latest_media_list_title_label'); ?></th>
            <th width="15%"><?php echo FactoryText::_('dashboard_latest_media_list_category_label'); ?></th>
            <th width="15%"><?php echo FactoryText::_('dashboard_latest_media_list_type_label'); ?></th>
            <th width="15%"><?php echo FactoryText::_('dashboard_latest_media_list_username_label'); ?></th>
            <th width="110px"><?php echo FactoryText::_('dashboard_latest_media_list_date_label'); ?></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($this->latestMediaPending as $this->i => $this->media): ?>
            <?php echo $this->loadTemplate('latest_media_item'); ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p><?php echo FactoryText::_('dashboard_list_no_items'); ?></p>
    <?php endif; ?>
  </div>
</div>
