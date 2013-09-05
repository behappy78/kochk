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

<?php JHtml::_('behavior.tooltip'); ?>
<?php JHtml::_('behavior.formvalidation'); ?>

<div class="factory-view-edit">
  <h1><?php echo FactoryText::_('authorizenet_credit_card_details'); ?></h1>

  <form method="post" action="<?php echo FactoryRoute::task('purchasecredits.purchase'); ?>" name="adminForm" id="adminForm" class="form-validate">
    <?php echo $this->form->render(); ?>

    <input type="submit" value="<?php echo FactoryText::_('authorizenet_continue'); ?>" />
  </form>
</div>
