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

<select name="filter_<?php echo $this->filter; ?>" class="inputbox" onchange="this.form.submit()">
  <option value=""><?php echo FactoryText::_('list_filter_'.$this->filter.'_label'); ?></option>
	<?php echo JHtml::_('select.options',
	  $this->get('filter'.$this->filter),
	  'value',
	  'text',
	  $this->state->get('filter.'.$this->filter),
	  true);?>
</select>
