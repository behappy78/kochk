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

<div class="factory-view view-profile factory-view-edit">
  <h1><?php echo FactoryText::_('parameters_page_title'); ?></h1>

  <form action="<?php echo FactoryRoute::view('parameters'); ?>" id="adminForm" name="adminForm" method="post" class="form-validate">
    <?php echo $this->loadTemplate('buttons'); ?>

    <?php echo $this->form->render(); ?>

    <?php echo $this->loadTemplate('buttons'); ?>

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>
