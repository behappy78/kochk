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
?>
<!-- Start Main Content -->
<?php  

$session =& JFactory::getSession();
$step = $session->get('step'); 
$maxSteps = (int)$session->get('maxSteps_');
?>
  <div class="title-bar"> <strong>Etape 1: Données d'identification:</strong> </div>
    <div class="side-holder frombox">
                        <ul class="billing-form">
                            <li>
                              <div class="control-group">
                                <label class="control-label" for="loginId">Identifiant<sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="loginId" name="loginId" class="required validate-alphanum minLength:3 maxLength:30 loginUnique">
                                </div>
                              </div>
                              
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="Password">Mot de passe <sup>*</sup></label>
                                <div class="controls">
                                  <input type="password" id="Password" name="Password" class="required">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="confPassword">Confirmez Mot de passe <sup>*</sup></label>
                                <div class="controls">
                                  <input type="password" id="confPassword" name="confPassword" class="required validate-match matchInput:'Password' matchName:'Password'">
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputEmail">Adresse Email <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="inputEmail" name="inputEmail" class="required validate-email emailUnique">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="confirmEmail">Confirmez Adresse Email <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="confirmEmail" name="confirmEmail" class="required validate-match matchInput:'inputEmail' matchName:'E-mail'">
                                </div>
                              </div>
                            </li>
                        	<li>
                            	<div class="control-group">
                                <div class="controls">
                                    <?php if ($step >= 1 && $step < $maxSteps){?>
                                      <input class="more-btn" id="next" name="next" type="button" onclick="submitFormK(1);" value="<?php echo FactoryText::_('profile_button_next'); ?>" />
                                    <?php }?>
                                    <?php if ($step > 1){?>
                                      <input class="more-btn" id="previous" name="previous" type="button" onclick="submitFormK(2);" value="<?php echo FactoryText::_('profile_button_previous'); ?>" />
                                    <?php }?>
                                      <input class="more-btn" id="cancel" name="cancel" type="button" onclick="submitFormK(0);location.href='<?php echo $url;?>';" value="<?php echo FactoryText::_('profile_button_cancel'); ?>" />
                                    <?php if ($step == $maxSteps){?>            
                                	  <input class="more-btn" id="save" name="save" type="button" onclick="submitFormK(3);" value="<?php echo FactoryText::_('profile_button_apply'); ?>" />
                                	<?php } ?>
                                
                                </div>
                              </div>
                            </li>
                        </ul>
                </div>