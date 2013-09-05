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

<div class="buttons">
  <input onclick="Joomla.submitbutton('media.apply');" type="button" value="<?php echo FactoryText::_('media_edit_button_apply'); ?>" />
  <input onclick="Joomla.submitbutton('media.save');" type="button" value="<?php echo FactoryText::_('media_edit_button_save'); ?>" />
  <input onclick="Joomla.submitbutton('media.save2new');" type="button" value="<?php echo FactoryText::_('media_edit_button_save_new'); ?>" />
  <input onclick="Joomla.submitbutton('media.cancel');" type="button" value="<?php echo $this->cancelTitle; ?>" />
</div>
