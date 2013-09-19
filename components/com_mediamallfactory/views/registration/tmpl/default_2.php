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
  <div class="title-bar"> <strong>Etape 2: Code de validation</strong> </div>
    <div class="side-holder frombox center">
                	<p>Pour poursuivre les étapes d'enregistrement, veuillez saisir le <em>Code de validation</em> que vous avez reçu par e-mail</p>
                    <form class="form-horizontal register-vcode">
                              <div class="control-group">
                                <label class="control-label" for="verifVcode">Code de Validation</label>
                                <div class="controls">
                                  <input type="number" id="verifVcode" class="center" placeholder="0-9">
                                </div>
                              </div>                           
                            
                            	<div class="control-group">
                                <div class="controls">
                                  <button type="submit" class="btn btn-large btn-primary">Valider</button>
                                </div>
                              </div>
                    </form>
                </div>
  </section>
</section>

