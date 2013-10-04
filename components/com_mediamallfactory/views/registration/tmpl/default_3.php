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
$session = JFactory::getSession();
$step = $session->get('step');
$stepD = $session->get('stepD');  
$maxSteps = (int)$session->get('maxSteps_');
$data = $session->get('data_'.$step);
?>

  <div class="title-bar"> <strong>Etape 3: Données Personnelles</strong> </div>
    <div class="side-holder frombox">
                        <ul class="billing-form">
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputFirstname">Prénom <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['inputFirstname']; ?>" id="inputFirstname" name="inputFirstname" class="required">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="inputLastname">Nom <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['inputLastname']; ?>" id="inputLastname" name="inputLastname" class="required">
                                </div>
                              </div>
                              
                            </li>
                            
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputAddress">Addresse<sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['inputAddress']; ?>" name="inputAddress" id="inputAddress" class="required address-field">
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputCity">Ville <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['inputCity']; ?>" id="inputCity" name="inputCity" class="required">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="inputZip">Code Postal/Zip <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['inputZip']; ?>" id="inputZip" name="inputZip" class="required">
                                </div>
                              </div>
                            </li>
                            <li>   
                              
                              <div class="control-group">
                                <label class="control-label" for="country">Pays <sup>*</sup></label>
                                <div class="controls">
                                  <select name="country">
                                  <?php 
                                      $db =& JFactory::getDBO();
                                      $query = $db->getQuery(true);
                                      $query->select('iso3, fr');
                                      $query->from('#__countries'); 
                                      $query->order('fr');
                                      $db->setQuery($query);
                                      if ($db->getErrorNum()) {
                                        echo $db->getErrorMsg();
                                      }
                                      $results = $db->loadObjectList();
                                      //echo $country;
                                      if ($results) {
                                          foreach ($results as $result) {
                                              $selected ='';
                                              if ($data['country'] == $result->iso3)
                                                  $selected = 'selected';
                                              echo '<option '.$selected.' value="'.$result->iso3.'">'.$result->fr.'</option>';
                                              //print_r($results);
                                          }
                                      } 
                                   ?>                                       	
                                   </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="jform_params_timezone">Fuseau Horaire (Optionnel)</sup></label>
                                <div class="controls">
                                  <select name="jform[params][timezone]" id="jform_params_timezone" class="" aria-invalid="false">
		<option selected="selected" value="">- Valeur par Défaut -</option>
</select>
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputTelephone">Téléphonne (Optionnel)</label>
                                <div class="controls">
                                  <input title="Veuillez entrer un numéro valide" type="text" name="inputTelephone" id="inputTelephone" value="<?php echo $data['inputTelephone']; ?>" class="validate-digits">
                                   <strong class="red-t">* Données Requises</strong>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="required control-label" for="inputFax">Fax (Optionnel)</label>
                                <div class="controls">
                                  <input type="text" id="inputFax" name="inputFax" value="<?php echo $data['inputFax']; ?>" class="validate-digits">
                                 
                                </div>
                              </div>
                            </li>
                        	<li>
                            	<div class="control-group">
                                <div class="controls">
                                  <button type="submit" class="more-btn">Continue</button>
                                </div>
                              </div>
                            </li>
                        </ul>
                            	<div class="control-group">
                                <div class="controls">
                                    <?php if ($step >= 1 && $step < $maxSteps){?>
                                      <input class="more-btn" id="next" name="next" type="button" onclick="submitFormK(1);" value="<?php echo FactoryText::_('profile_button_next'); ?>" />
                                    <?php }?>
                                    <?php if ($step > 1 && $step != $stepD){?>
                                      <input class="more-btn" id="previous" name="previous" type="button" onclick="submitFormK(2);" value="<?php echo FactoryText::_('profile_button_previous'); ?>" />
                                    <?php }
                                    
                                    ?>
                                      <input class="more-btn" id="cancel" name="cancel" type="button" onclick="submitFormK(0);" value="<?php echo FactoryText::_('profile_button_cancel'); ?>" />
                                    <?php if ($step == $maxSteps){
                                    
                                        ?>   
                                             
                                	  <input class="more-btn" id="save" name="save" type="button" onclick="submitFormK(3);" value="<?php echo FactoryText::_('profile_button_apply'); ?>" />
                                	<?php } ?>
                                </div>
                              </div>
                </div>

