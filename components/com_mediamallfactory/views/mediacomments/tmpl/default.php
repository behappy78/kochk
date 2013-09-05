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

<div class="factory-view view-adminmessages factory-view-edit factory-view-list">
  <h1><?php echo FactoryText::sprintf('mediacomments_page_title', $this->media->title, $this->media->id); ?></h1>

  <?php echo $this->loadTemplate('adminmessages/items', array('legend' => FactoryText::_('mediacomments_messages'))); ?>

  <form action="<?php echo FactoryRoute::task('mediacomment.save&media_id='.$this->media->id); ?>" method="post" id="adminForm" name="adminForm" class="form-validate">
    <?php echo $this->form->render(); ?>
    <input type="submit" value="<?php echo FactoryText::_('adminmessages_submit_message'); ?>" />
  </form>
</div>
