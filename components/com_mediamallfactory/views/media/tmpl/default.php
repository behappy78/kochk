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

defined('_JEXEC') or die;


?>

<div class="factory-view view-media">
  <h1><?php echo $this->item->title; ?></h1>

  <?php echo $this->loadTemplate('details'); ?>
  <?php echo $this->loadTemplate('interact'); ?>
  <?php echo $this->loadTemplate('write_review'); ?>
  <?php echo $this->loadTemplate('reviews'); ?>
</div>
