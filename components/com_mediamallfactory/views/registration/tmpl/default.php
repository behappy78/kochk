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
JHTML::_('behavior.mootools');
JHTML::_('behavior.framework', true);
$document = JFactory::getDocument();
$link = FactoryRoute::view('registration');
$link .= "&format=raw"; 
// Add Javascript
$document->addScriptDeclaration("
			function submitFormK(e) {

				// Prevents the default submit event from loading a new page.
				//e.stop();
				//alert('dsfgdfgdfg'+e);
				theform = document.id('adminForm');
				document.id('step').value = e;
				//alert('before send');
				theform.set('send', {
					onComplete: function(response) {
						document.id('kochkmain').set('html', response);
					}
				});
				// Send the form.
				theform.send();
				
			};
 
");
$session =& JFactory::getSession();
$step = $session->get('step'); 
$maxSteps = (int)$session->get('maxSteps_');
?>

<div <?php if ($step == 1) echo 'id="kochkmain"';?> class="heading-bar">
  <h2><?php echo FactoryText::_('register_page_title'); ?></h2>
  <span class="h-line"></span> </div>
<!-- Start Main Content -->
<section class="register-holder">
  <section class="span12 first">
    <div class="accordion" id="accordion2">
      <div class="accordion-group">
        <div class="register-form-heading">
          <h3 class="register-form-toggle"> Checkout Method </h3>
        </div>
        <div id="collapseOne" class="accordion-body collapse in">
          <div class="accordion-inner">
            <div class="span6 check-method-left"> <strong class="green-t">Identification:</strong>
              <p>Vous êtes déjà membre? Veuillez vous identifier:</p>
              <form class="form-horizontal">
                <div class="control-group">
                  <label class="control-label" for="inputEmail">Email Address <sup>*</sup></label>
                  <div class="controls">
                    <input type="text" id="inputEmail" placeholder="">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputPassword">Password <sup>*</sup></label>
                  <div class="controls">
                    <input type="password" id="inputPassword" placeholder="">
                  </div>
                </div>
                <p><a href="#">Forgot your password?</a></p>
                <div class="control-group">
                  <div class="controls">
                    <button type="submit" class="more-btn">Login</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="span5 check-method-right"> <strong class="green-t">JE N'AI PAS DE COMPTE</strong>
              <p>Inscrivez-vous et devenez membre en quelques cliques:</p>
                <center><a href="#" class="more-btn"><i class="icon-user"></i>Rejoignez-nous sur kochk.com</a> </center>
                
             </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>
<div class="factory-view view-profile factory-view-edit">
  <h1><?php echo FactoryText::_('register_page_title'); ?></h1>
  <form action="<?php echo $link ?>" id="adminForm" name="adminForm" method="post" class="form-validate">
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="step" id="step" value="" />
    <?php //echo $this->loadTemplate('buttons'); ?>
    <?php echo $this->form->render(); 
    $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=list");
    ?>
    <div class="buttons">
      <?php if ($step >= 1 && $step < $maxSteps){?>
      <input id="next" name="next" type="button" onclick="submitFormK(1);" value="<?php echo FactoryText::_('profile_button_next'); ?>" />
      <?php }?>
      <?php if ($step > 1){?>
      <input id="previous" name="previous" type="button" onclick="submitFormK(2);" value="<?php echo FactoryText::_('profile_button_previous'); ?>" />
      <?php }?>
      <input id="cancel" name="cancel" type="button" onclick="submitFormK(0);location.href='<?php echo $url;?>';" value="<?php echo FactoryText::_('profile_button_cancel'); ?>" />
      <?php if ($step == $maxSteps){?>
      <input id="save" name="save" type="button" onclick="submitFormK(3);" value="<?php echo FactoryText::_('profile_button_apply'); ?>" />
      <?php }?>
    </div>
    <?php

	    if ($step == 1)
            echo '</div>';
        //if ($step == 1)
         //echo $this->loadTemplate('buttons1');
        //else 
            //if ($step == $maxSteps)
             //echo $this->loadTemplate('buttons2');
            //else 
             //echo $this->loadTemplate('buttons');
         
         //print_r($step);
    ?>
  </form>
</div>
