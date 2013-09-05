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

<div class="factory-view view-historycredits factory-view-list">
  <h1><?php echo FactoryText::_('historycredits_page_title'); ?></h1>

  <?php echo JHtml::_('Factory.beginForm', FactoryRoute::view('historycredits')); ?>
    <?php echo $this->loadTemplate('filters'); ?>

    <?php if ($this->items): ?>
      <table>
        <?php echo $this->loadTemplate('head'); ?>
        <?php echo $this->loadTemplate('foot'); ?>
        <?php echo $this->loadTemplate('body'); ?>
      </table>
    <?php else: ?>
      <p><?php echo FactoryText::_('historycredits_no_results_found'); ?></p>
    <?php endif; ?>
  </form>
</div>

