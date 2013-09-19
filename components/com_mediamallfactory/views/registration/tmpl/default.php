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
                	<strong class="green-t">Checkout as Guest</strong>
                    <form class="form-horizontal">
                        <ul class="billing-form">
                            <li>
                              <div class="control-group">
                                <label class="control-label" for="loginId">Identifiant<sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="loginId" placeholder="A-z, 0-9">
                                </div>
                              </div>
                              
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputPassword">Mot de passe <sup>*</sup></label>
                                <div class="controls">
                                  <input type="password" id="inputPassword" placeholder="">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="confirmPassword">Confirmez Mot de passe <sup>*</sup></label>
                                <div class="controls">
                                  <input type="password" id="confirmPassword" placeholder="">
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputEmail">Adresse Email <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="inputEmail" placeholder="">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="confirmEmail">Confirmez Adresse Email <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="confirmEmail" placeholder="">
                                </div>
                              </div>
                            </li>
                        	<li>
                            	<div class="control-group">
                                <div class="controls">
                                  <button type="submit" class="more-btn">Continuer</button>
                                </div>
                              </div>
                            </li>
                        </ul>
                    </form>
                </div>
        </div>
      </div>
    </div>
  </section>
</section>

