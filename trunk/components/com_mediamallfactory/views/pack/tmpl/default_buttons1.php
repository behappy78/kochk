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
  <input onclick="submitFormK(1);" type="button" value="<?php echo FactoryText::_('profile_button_next'); ?>" />
  <input id="cancel" onclick="submitFormK(2);" name="cancel" type="button" value="<?php echo FactoryText::_('profile_button_cancel'); ?>" />
  <input type="button" onclick="submitFormK(3);" value="<?php echo FactoryText::_('profile_button_save'); ?>" />
</div>
