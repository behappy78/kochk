<?php 
defined('_JEXEC') or die; 
$app = JFactory::getApplication();
JHtml::_('behavior.keepalive');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
?>

<!-- Start Main Content -->
<section class="register-holder">
  <section class="span12 first">
    <div class="accordion" id="accordion2">
      <div class="accordion-group">
      <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="register-form-heading">
          <h3 class="register-form-toggle"> <?php echo $this->escape($this->params->get('page_heading')); ?> </h3>
        </div>
        <?php endif; ?>
        <div id="collapseOne" class="accordion-body collapse in">
          <div class="accordion-inner">
            <div class="span6 check-method-left"> <strong class="green-t">IDENTIFICATION:</strong>
              <p>Vous êtes déjà membre? Veuillez vous identifier:</p>
              <form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
              <?php
			  $this->form->reset( true ); // to reset the form xml loaded by the view
			  $this->form->loadFile( dirname(__FILE__) . DS . "login.xml"); // to load in our own version of login.xml
			  ?>
			<fieldset>
              <?php foreach ($this->form->getFieldset('credentials') as $field): ?>
				<?php if (!$field->hidden): ?>
					<div class="control-group">
						<?php echo $field->label; ?>
                        <div class="controls">                        
							<?php echo $field->input; ?>
                    	</div>
                     </div>
				<?php endif; ?>
			<?php endforeach; ?>
			
			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>   	
                <div class="control-group">
                  <div class="controls">
                  <label class="checkbox">
                     <input type="checkbox" id="remember" name="remember" alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>"> <?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>
                   </label>
                  </div>
                </div>
                <?php endif; ?>
				<div class="control-group">
                  <div class="controls center">
                    <button type="submit" class="more-btn left"><?php echo JText::_('JLOGIN'); ?></button>
                    <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo JHtml::_('form.token'); ?>
			
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="right"><?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
                  </div>
                </div>
                </fieldset>
              </form>
            </div>
            <div class="span5 check-method-right"> <strong class="green-t">JE N'AI PAS DE COMPTE: </strong>
              <p>L'inscription sur kochk.com vous permet d'acheter en toute sécurité des Crédits et les gérer afin de pouvoir télécharger les journaux et magazines qui vous conviennent, ainsi que de vous y abonner.</p>
			  <?php
              $usersConfig = JComponentHelper::getParams('com_users');
			  if ($usersConfig->get('allowUserRegistration')) : ?>
              <center>
                <a href="<?php echo JRoute::_('index.php?option=com_mediamallfactory&view=registration'); ?>" class="more-btn nofloat"><?php echo JText::_('TPL_KIOSK_YOUR_SITE_DESCRIPTION'); ?></a>
                </center>
				<?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>