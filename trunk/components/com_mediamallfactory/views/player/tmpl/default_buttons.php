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
  <a href="<?php echo FactoryRoute::view('media&media_id=' . $this->item->id); ?>" class="factory-button-text button-back-medium"><?php echo FactoryText::_('player_back_button_text'); ?></a>
  <a href="<?php echo FactoryRoute::view('media&media_id=' . $this->item->id . '#write-review'); ?>" class="factory-button-text button-ballon-plus"><?php echo FactoryText::_('player_review_button_text'); ?></a>
</div>
