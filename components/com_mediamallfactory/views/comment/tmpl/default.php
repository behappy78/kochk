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

<div class="factory-view view-comment">
  <p><?php echo FactoryText::_('review_information'); ?></p>
  <form action="<?php echo FactoryRoute::task('comment.save'); ?>" method="POST" class="form-validate">
    <?php echo $this->form->render('form', FactoryApplication::getInstance()->getPath('component_site').DS.'views'.DS.$this->getName().DS.'tmpl'.DS); ?>

    <input type="submit" value="<?php echo FactoryText::_('form_comment_save_button'); ?>" />
    <a href="#" class="factory-button-text button-cross hide-review-form"><?php echo FactoryText::_('form_comment_cancel_button'); ?></a>
  </form>
</div>
