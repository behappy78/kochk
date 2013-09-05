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

<form action="<?php echo FactoryRoute::view('withdrawfunds'); ?>" method="POST" class="form-validate" id="adminForm" name="adminForm">
  <?php echo $this->loadTemplate('buttons'); ?>

  <?php echo $this->form->render(); ?>

  <?php echo $this->loadTemplate('buttons'); ?>

  <?php echo JHtml::_('form.token'); ?>
  <input type="hidden" name="task" />
</form>
