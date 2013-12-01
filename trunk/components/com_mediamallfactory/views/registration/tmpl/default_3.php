<?php 


defined('_JEXEC') or die; 
$session = JFactory::getSession();
$step = $session->get('step');
$stepD = $session->get('stepD');  
$maxSteps = (int)$session->get('maxSteps_');

$data1    = JRequest::get( 'post' );
if ($data1)
    $data = $data1;
$data = $session->get('data_'.$step);
?>

  <div class="title-bar"> <strong><?php echo FactoryText::_('registration_steps_3_title');?></strong> </div>
    <div class="side-holder frombox">
                        <ul class="billing-form">
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="first_name"><?php echo FactoryText::_('registration_user_firstname');?> <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['first_name']; ?>" id="first_name" name="first_name" class="required">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="last_name"><?php echo FactoryText::_('registration_user_lastname');?> <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['last_name']; ?>" id="last_name" name="last_name" class="required">
                                </div>
                              </div>
                              
                            </li>
                            
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="address"><?php echo FactoryText::_('registration_user_invoice_adresse');?><sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['address']; ?>" name="address" id="address" class="required address-field">
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="city"><?php echo FactoryText::_('registration_user_city');?> <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['city']; ?>" id="city" name="city" class="required">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="zip"><?php echo FactoryText::_('registration_user_zipcode');?> <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['zip']; ?>" id="zip" name="zip" class="required">
                                </div>
                              </div>
                            </li>
                            <li>   
                              
                              <div class="control-group">
                                <label class="control-label" for="country"><?php echo FactoryText::_('registration_user_country');?> <sup>*</sup></label>
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
                                <label class="control-label" for="timezone"><?php echo FactoryText::_('registration_user_timezone');?> <?php echo FactoryText::_('optional');?></sup></label>
                                <div class="controls">
                                  <select name="timezone" id="timezone" class="" aria-invalid="false">
		<option selected="selected" value="0">- Valeur par Défaut -</option>
</select>
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="phone"><?php echo FactoryText::_('registration_user_phone');?> <?php echo FactoryText::_('optional');?></label>
                                <div class="controls">
                                  <input title="Veuillez entrer un numéro valide" type="text" name="phone" id="phone" value="<?php echo $data['phone']; ?>" class="validate-digits">
                                   <strong class="red-t">* <?php echo FactoryText::_('Requested_data');?></strong>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="required control-label" for="fax"><?php echo FactoryText::_('registration_user_fax');?> <?php echo FactoryText::_('optional');?></label>
                                <div class="controls">
                                  <input type="text" id="fax" name="fax" value="<?php echo $data['fax']; ?>" class="validate-digits">
                                 
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

