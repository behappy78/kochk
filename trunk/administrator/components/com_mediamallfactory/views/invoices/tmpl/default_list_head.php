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

<tr>
  <th width="1%">
	  <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
	</th>

	<th>
    <?php echo JHtml::_('FactoryAdmin.sort', 'invoice_list_title', 'title', $this->state); ?>
	</th>

  <th width="10%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'invoice_list_username', 'u.username', $this->state); ?>
  </th>

  <th width="10%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'invoice_list_amount', 'amount', $this->state); ?>
  </th>

  <th width="10%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'invoice_list_vat', 'vat_value', $this->state); ?>
  </th>

  <th width="10%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'invoice_list_date', 'created_at', $this->state); ?>
  </th>
</tr>
