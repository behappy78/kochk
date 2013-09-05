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
    <?php echo JHtml::_('FactoryAdmin.sort', 'list_list_title', 'title', $this->state); ?>
	</th>

  <th width="8%">
    <small><?php echo JHtml::_('FactoryAdmin.sort', 'list_list_messages', 'messages', $this->state); ?></small>
	</th>

  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'list_list_rating', 'rating', $this->state); ?>
	</th>

  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'list_list_category', 'category_title', $this->state); ?>
	</th>

  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'list_list_type', 'type_title', $this->state); ?>
	</th>

  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'list_list_username', 'username', $this->state); ?>
	</th>

  <th width="120px">
    <?php echo JHtml::_('FactoryAdmin.sort', 'list_list_date', 'created_at', $this->state); ?>
	</th>

  <th width="5%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'list_list_published', 'published', $this->state); ?>
	</th>
</tr>
