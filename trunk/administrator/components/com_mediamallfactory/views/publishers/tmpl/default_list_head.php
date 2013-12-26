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
	<th width="2%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'categories_list_thumb', 'thumbnail', $this->state); ?>
	</th>

	<th>
    <?php echo JHtml::_('FactoryAdmin.sort', 'categories_list_title', 'title', $this->state); ?>
	</th>

  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'categories_list_parent', 'parent', $this->state); ?>
	</th>

  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'categories_list_icountry', 'icountyn', $this->state); ?>
	</th>
  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'categories_list_icountrygroup', 'incountries', $this->state); ?>
	</th>
  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'categories_list_ecountry', 'ecountryn', $this->state); ?>
	</th>
  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'categories_list_ecountrygroup', 'excountries', $this->state); ?>
	</th>
	
  <th width="8%">
    <?php echo JHtml::_('FactoryAdmin.sort', 'currencies_list_published', 'published', $this->state); ?>
	</th>
</tr>
