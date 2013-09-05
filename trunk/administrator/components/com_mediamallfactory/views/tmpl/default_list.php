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

<div class="factory-view">
  <?php echo $this->loadTemplate('/list_form'); ?>
    <?php echo $this->loadTemplate('/list_filters'); ?>

    <table class="adminlist">
      <thead>
        <?php echo $this->loadTemplate('/list_head'); ?>
      </thead>

      <tfoot>
        <?php echo $this->loadTemplate('/list_foot'); ?>
      </tfoot>

      <tbody>
        <?php foreach ($this->items as $this->i => $this->item): ?>
          <?php echo $this->loadTemplate('/list_body'); ?>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php echo $this->loadTemplate('/list_hidden'); ?>
  </form>
</div>
