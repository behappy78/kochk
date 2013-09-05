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

<form action="<?php echo $this->form_action; ?>" method="post" id="adminForm" name="adminForm" class="form-validate">
  <?php echo $this->loadTemplate('/fieldset', array('fieldset' => 'details')); ?>

  <input type="submit" value="<?php echo FactoryText::_('adminmessages_submit_message'); ?>" />
</form>
