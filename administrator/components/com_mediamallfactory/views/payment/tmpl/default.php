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

<div class="factory-view view-edit factory-view-edit">
  <form action="" method="post" id="adminForm" name="adminForm" class="form-validate" enctype="multipart/form-data">
    <div class="width-60 fltlft">
      <?php echo $this->form->render(); ?>
    </div>

    <div class="width-40 fltrt">
			<?php echo JHtml::_('sliders.start', 'payment-sliders-'.$this->item->id, array('useCookie' => 1)); ?>
				<?php echo JHtml::_('sliders.panel', FactoryText::_('payment_errors_slider_title'), 'errors'); ?>
          <?php echo $this->form->getField('errors')->input; ?>
				<?php echo JHtml::_('sliders.panel', FactoryText::_('payment_request_slider_title'), 'request'); ?>
          <?php echo $this->form->getField('request')->input; ?>
			<?php echo JHtml::_('sliders.end'); ?>
    </div>

    <input type="hidden" name="task" />
  </form>
</div>

