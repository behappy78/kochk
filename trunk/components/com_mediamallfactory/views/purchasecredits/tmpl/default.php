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

<div class="factory-view view-purchasecredits factory-view-edit">
  <h1><?php echo FactoryText::_('purchasecredits_page_title'); ?></h1>

  <form action="" method="post" id="adminForm" name="adminForm" class="form-validate">
    <?php echo $this->loadTemplate('buttons'); ?>

    <?php if ($this->bonuses): ?>
      <fieldset>
        <legend><?php echo FactoryText::_('purchasecredits_bonuses'); ?></legend>

        <table class="factory-view-list">
          <thead>
            <tr>
              <th class="center"><?php echo FactoryText::_('purchasecredits_bonus_list_credits'); ?></th>
              <th class="center"><?php echo FactoryText::_('purchasecredits_bonus_list_bonus'); ?></th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($this->bonuses as $this->i => $this->bonus): ?>
              <tr class="<?php echo $this->i % 2 ? '' : 'even'; ?>">
                <td class="center"><?php echo $this->bonus->credits; ?></td>
                <td class="center"><?php echo $this->bonus->bonus; ?></td>
                <td></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </fieldset>
    <?php endif; ?>

    <?php echo $this->form->render(); ?>

    <?php echo $this->loadTemplate('buttons'); ?>

    <input type="hidden" name="task" />
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>
