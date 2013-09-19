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
  <div class="title-bar"> <strong>Etape 3: Données Personnelles</strong> </div>
    <div class="side-holder frombox">
                	
                    <form class="form-horizontal">
                        <ul class="billing-form">
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputFirstname">Prénom <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="inputFirstname" placeholder="">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="inputLastname">Nom <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="inputLastname" placeholder="">
                                </div>
                              </div>
                              
                            </li>
                            
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputAddress">Addresse<sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="inputAddress" placeholder="" class="address-field">
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputCity">Ville <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="inputCity" placeholder="">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="inputZip">Code Postal/Zip <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" id="inputZip" placeholder="">
                                </div>
                              </div>
                            </li>
                            <li>   
                              
                              <div class="control-group">
                                <label class="control-label" for="inputCountry">Pays <sup>*</sup></label>
                                <div class="controls">
                                  <select name="country">
                                        <option value="">United States...</option>
                                        <option value="Afganistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bonaire">Bonaire</option>
                                        <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canary Islands">Canary Islands</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Channel Islands">Channel Islands</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Island">Cocos Island</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cote DIvoire">Cote D'Ivoire</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Curaco">Curacao</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Ter">French Southern Ter</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Great Britain">Great Britain</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Hawaii">Hawaii</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea North">Korea North</option>
                                        <option value="Korea Sout">Korea South</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libya">Libya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Midway Islands">Midway Islands</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Nambia">Nambia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherland Antilles">Netherland Antilles</option>
                                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                        <option value="Nevis">Nevis</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau Island">Palau Island</option>
                                        <option value="Palestine">Palestine</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Phillipines">Philippines</option>
                                        <option value="Pitcairn Island">Pitcairn Island</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                                        <option value="Republic of Serbia">Republic of Serbia</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="St Barthelemy">St Barthelemy</option>
                                        <option value="St Eustatius">St Eustatius</option>
                                        <option value="St Helena">St Helena</option>
                                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                        <option value="St Lucia">St Lucia</option>
                                        <option value="St Maarten">St Maarten</option>
                                        <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                        <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                                        <option value="Saipan">Saipan</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="Samoa American">Samoa American</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome & Principe">Sao Tome &amp; Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syria</option>
                                        <option value="Tahiti">Tahiti</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Erimates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States of America">United States of America</option>
                                        <option value="Uraguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City State">Vatican City State</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                        <option value="Wake Island">Wake Island</option>
                                        <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zaire">Zaire</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                   </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="jform_params_timezone">Fuseau Horaire (Optionnel)</sup></label>
                                <div class="controls">
                                  <select name="jform[params][timezone]" id="jform_params_timezone" class="" aria-invalid="false">
		<option selected="selected" value="">- Valeur par Défaut -</option>
	<optgroup label="Africa">
		<option value="Africa/Abidjan">Abidjan</option>
		<option value="Africa/Accra">Accra</option>
		<option value="Africa/Addis_Ababa">Addis Ababa</option>
		<option value="Africa/Algiers">Algiers</option>
		<option value="Africa/Asmara">Asmara</option>
		<option value="Africa/Bamako">Bamako</option>
		<option value="Africa/Bangui">Bangui</option>
		<option value="Africa/Banjul">Banjul</option>
		<option value="Africa/Bissau">Bissau</option>
		<option value="Africa/Blantyre">Blantyre</option>
		<option value="Africa/Brazzaville">Brazzaville</option>
		<option value="Africa/Bujumbura">Bujumbura</option>
		<option value="Africa/Cairo">Cairo</option>
		<option value="Africa/Casablanca">Casablanca</option>
		<option value="Africa/Ceuta">Ceuta</option>
		<option value="Africa/Conakry">Conakry</option>
		<option value="Africa/Dakar">Dakar</option>
		<option value="Africa/Dar_es_Salaam">Dar es Salaam</option>
		<option value="Africa/Djibouti">Djibouti</option>
		<option value="Africa/Douala">Douala</option>
		<option value="Africa/El_Aaiun">El Aaiun</option>
		<option value="Africa/Freetown">Freetown</option>
		<option value="Africa/Gaborone">Gaborone</option>
		<option value="Africa/Harare">Harare</option>
		<option value="Africa/Johannesburg">Johannesburg</option>
		<option value="Africa/Kampala">Kampala</option>
		<option value="Africa/Khartoum">Khartoum</option>
		<option value="Africa/Kigali">Kigali</option>
		<option value="Africa/Kinshasa">Kinshasa</option>
		<option value="Africa/Lagos">Lagos</option>
		<option value="Africa/Libreville">Libreville</option>
		<option value="Africa/Lome">Lome</option>
		<option value="Africa/Luanda">Luanda</option>
		<option value="Africa/Lubumbashi">Lubumbashi</option>
		<option value="Africa/Lusaka">Lusaka</option>
		<option value="Africa/Malabo">Malabo</option>
		<option value="Africa/Maputo">Maputo</option>
		<option value="Africa/Maseru">Maseru</option>
		<option value="Africa/Mbabane">Mbabane</option>
		<option value="Africa/Mogadishu">Mogadishu</option>
		<option value="Africa/Monrovia">Monrovia</option>
		<option value="Africa/Nairobi">Nairobi</option>
		<option value="Africa/Ndjamena">Ndjamena</option>
		<option value="Africa/Niamey">Niamey</option>
		<option value="Africa/Nouakchott">Nouakchott</option>
		<option value="Africa/Ouagadougou">Ouagadougou</option>
		<option value="Africa/Porto-Novo">Porto-Novo</option>
		<option value="Africa/Sao_Tome">Sao Tome</option>
		<option value="Africa/Tripoli">Tripoli</option>
		<option value="Africa/Tunis">Tunis</option>
		<option value="Africa/Windhoek">Windhoek</option>
	</optgroup>
	<optgroup label="America">
		<option value="America/Adak">Adak</option>
		<option value="America/Anchorage">Anchorage</option>
		<option value="America/Anguilla">Anguilla</option>
		<option value="America/Antigua">Antigua</option>
		<option value="America/Araguaina">Araguaina</option>
		<option value="America/Argentina/Buenos_Aires">Argentina/Buenos Aires</option>
		<option value="America/Argentina/Catamarca">Argentina/Catamarca</option>
		<option value="America/Argentina/Cordoba">Argentina/Cordoba</option>
		<option value="America/Argentina/Jujuy">Argentina/Jujuy</option>
		<option value="America/Argentina/La_Rioja">Argentina/La Rioja</option>
		<option value="America/Argentina/Mendoza">Argentina/Mendoza</option>
		<option value="America/Argentina/Rio_Gallegos">Argentina/Rio Gallegos</option>
		<option value="America/Argentina/Salta">Argentina/Salta</option>
		<option value="America/Argentina/San_Juan">Argentina/San Juan</option>
		<option value="America/Argentina/San_Luis">Argentina/San Luis</option>
		<option value="America/Argentina/Tucuman">Argentina/Tucuman</option>
		<option value="America/Argentina/Ushuaia">Argentina/Ushuaia</option>
		<option value="America/Aruba">Aruba</option>
		<option value="America/Asuncion">Asuncion</option>
		<option value="America/Atikokan">Atikokan</option>
		<option value="America/Bahia">Bahia</option>
		<option value="America/Bahia_Banderas">Bahia Banderas</option>
		<option value="America/Barbados">Barbados</option>
		<option value="America/Belem">Belem</option>
		<option value="America/Belize">Belize</option>
		<option value="America/Blanc-Sablon">Blanc-Sablon</option>
		<option value="America/Boa_Vista">Boa Vista</option>
		<option value="America/Bogota">Bogota</option>
		<option value="America/Boise">Boise</option>
		<option value="America/Cambridge_Bay">Cambridge Bay</option>
		<option value="America/Campo_Grande">Campo Grande</option>
		<option value="America/Cancun">Cancun</option>
		<option value="America/Caracas">Caracas</option>
		<option value="America/Cayenne">Cayenne</option>
		<option value="America/Cayman">Cayman</option>
		<option value="America/Chicago">Chicago</option>
		<option value="America/Chihuahua">Chihuahua</option>
		<option value="America/Costa_Rica">Costa Rica</option>
		<option value="America/Cuiaba">Cuiaba</option>
		<option value="America/Curacao">Curacao</option>
		<option value="America/Danmarkshavn">Danmarkshavn</option>
		<option value="America/Dawson">Dawson</option>
		<option value="America/Dawson_Creek">Dawson Creek</option>
		<option value="America/Denver">Denver</option>
		<option value="America/Detroit">Detroit</option>
		<option value="America/Dominica">Dominica</option>
		<option value="America/Edmonton">Edmonton</option>
		<option value="America/Eirunepe">Eirunepe</option>
		<option value="America/El_Salvador">El Salvador</option>
		<option value="America/Fortaleza">Fortaleza</option>
		<option value="America/Glace_Bay">Glace Bay</option>
		<option value="America/Godthab">Godthab</option>
		<option value="America/Goose_Bay">Goose Bay</option>
		<option value="America/Grand_Turk">Grand Turk</option>
		<option value="America/Grenada">Grenada</option>
		<option value="America/Guadeloupe">Guadeloupe</option>
		<option value="America/Guatemala">Guatemala</option>
		<option value="America/Guayaquil">Guayaquil</option>
		<option value="America/Guyana">Guyana</option>
		<option value="America/Halifax">Halifax</option>
		<option value="America/Havana">Havana</option>
		<option value="America/Hermosillo">Hermosillo</option>
		<option value="America/Indiana/Indianapolis">Indiana/Indianapolis</option>
		<option value="America/Indiana/Knox">Indiana/Knox</option>
		<option value="America/Indiana/Marengo">Indiana/Marengo</option>
		<option value="America/Indiana/Petersburg">Indiana/Petersburg</option>
		<option value="America/Indiana/Tell_City">Indiana/Tell City</option>
		<option value="America/Indiana/Vevay">Indiana/Vevay</option>
		<option value="America/Indiana/Vincennes">Indiana/Vincennes</option>
		<option value="America/Indiana/Winamac">Indiana/Winamac</option>
		<option value="America/Inuvik">Inuvik</option>
		<option value="America/Iqaluit">Iqaluit</option>
		<option value="America/Jamaica">Jamaica</option>
		<option value="America/Juneau">Juneau</option>
		<option value="America/Kentucky/Louisville">Kentucky/Louisville</option>
		<option value="America/Kentucky/Monticello">Kentucky/Monticello</option>
		<option value="America/La_Paz">La Paz</option>
		<option value="America/Lima">Lima</option>
		<option value="America/Los_Angeles">Los Angeles</option>
		<option value="America/Maceio">Maceio</option>
		<option value="America/Managua">Managua</option>
		<option value="America/Manaus">Manaus</option>
		<option value="America/Marigot">Marigot</option>
		<option value="America/Martinique">Martinique</option>
		<option value="America/Matamoros">Matamoros</option>
		<option value="America/Mazatlan">Mazatlan</option>
		<option value="America/Menominee">Menominee</option>
		<option value="America/Merida">Merida</option>
		<option value="America/Mexico_City">Mexico City</option>
		<option value="America/Miquelon">Miquelon</option>
		<option value="America/Moncton">Moncton</option>
		<option value="America/Monterrey">Monterrey</option>
		<option value="America/Montevideo">Montevideo</option>
		<option value="America/Montreal">Montreal</option>
		<option value="America/Montserrat">Montserrat</option>
		<option value="America/Nassau">Nassau</option>
		<option value="America/New_York">New York</option>
		<option value="America/Nipigon">Nipigon</option>
		<option value="America/Nome">Nome</option>
		<option value="America/Noronha">Noronha</option>
		<option value="America/North_Dakota/Center">North Dakota/Center</option>
		<option value="America/North_Dakota/New_Salem">North Dakota/New Salem</option>
		<option value="America/Ojinaga">Ojinaga</option>
		<option value="America/Panama">Panama</option>
		<option value="America/Pangnirtung">Pangnirtung</option>
		<option value="America/Paramaribo">Paramaribo</option>
		<option value="America/Phoenix">Phoenix</option>
		<option value="America/Port-au-Prince">Port-au-Prince</option>
		<option value="America/Port_of_Spain">Port of Spain</option>
		<option value="America/Porto_Velho">Porto Velho</option>
		<option value="America/Puerto_Rico">Puerto Rico</option>
		<option value="America/Rainy_River">Rainy River</option>
		<option value="America/Rankin_Inlet">Rankin Inlet</option>
		<option value="America/Recife">Recife</option>
		<option value="America/Regina">Regina</option>
		<option value="America/Resolute">Resolute</option>
		<option value="America/Rio_Branco">Rio Branco</option>
		<option value="America/Santa_Isabel">Santa Isabel</option>
		<option value="America/Santarem">Santarem</option>
		<option value="America/Santiago">Santiago</option>
		<option value="America/Santo_Domingo">Santo Domingo</option>
		<option value="America/Sao_Paulo">Sao Paulo</option>
		<option value="America/Scoresbysund">Scoresbysund</option>
		<option value="America/Shiprock">Shiprock</option>
		<option value="America/St_Barthelemy">St Barthelemy</option>
		<option value="America/St_Johns">St Johns</option>
		<option value="America/St_Kitts">St Kitts</option>
		<option value="America/St_Lucia">St Lucia</option>
		<option value="America/St_Thomas">St Thomas</option>
		<option value="America/St_Vincent">St Vincent</option>
		<option value="America/Swift_Current">Swift Current</option>
		<option value="America/Tegucigalpa">Tegucigalpa</option>
		<option value="America/Thule">Thule</option>
		<option value="America/Thunder_Bay">Thunder Bay</option>
		<option value="America/Tijuana">Tijuana</option>
		<option value="America/Toronto">Toronto</option>
		<option value="America/Tortola">Tortola</option>
		<option value="America/Vancouver">Vancouver</option>
		<option value="America/Whitehorse">Whitehorse</option>
		<option value="America/Winnipeg">Winnipeg</option>
		<option value="America/Yakutat">Yakutat</option>
		<option value="America/Yellowknife">Yellowknife</option>
	</optgroup>
	<optgroup label="Antarctica">
		<option value="Antarctica/Casey">Casey</option>
		<option value="Antarctica/Davis">Davis</option>
		<option value="Antarctica/DumontDUrville">DumontDUrville</option>
		<option value="Antarctica/Macquarie">Macquarie</option>
		<option value="Antarctica/Mawson">Mawson</option>
		<option value="Antarctica/McMurdo">McMurdo</option>
		<option value="Antarctica/Palmer">Palmer</option>
		<option value="Antarctica/Rothera">Rothera</option>
		<option value="Antarctica/South_Pole">South Pole</option>
		<option value="Antarctica/Syowa">Syowa</option>
		<option value="Antarctica/Vostok">Vostok</option>
	</optgroup>
	<optgroup label="Arctic">
		<option value="Arctic/Longyearbyen">Longyearbyen</option>
	</optgroup>
	<optgroup label="Asia">
		<option value="Asia/Aden">Aden</option>
		<option value="Asia/Almaty">Almaty</option>
		<option value="Asia/Amman">Amman</option>
		<option value="Asia/Anadyr">Anadyr</option>
		<option value="Asia/Aqtau">Aqtau</option>
		<option value="Asia/Aqtobe">Aqtobe</option>
		<option value="Asia/Ashgabat">Ashgabat</option>
		<option value="Asia/Baghdad">Baghdad</option>
		<option value="Asia/Bahrain">Bahrain</option>
		<option value="Asia/Baku">Baku</option>
		<option value="Asia/Bangkok">Bangkok</option>
		<option value="Asia/Beirut">Beirut</option>
		<option value="Asia/Bishkek">Bishkek</option>
		<option value="Asia/Brunei">Brunei</option>
		<option value="Asia/Choibalsan">Choibalsan</option>
		<option value="Asia/Chongqing">Chongqing</option>
		<option value="Asia/Colombo">Colombo</option>
		<option value="Asia/Damascus">Damascus</option>
		<option value="Asia/Dhaka">Dhaka</option>
		<option value="Asia/Dili">Dili</option>
		<option value="Asia/Dubai">Dubai</option>
		<option value="Asia/Dushanbe">Dushanbe</option>
		<option value="Asia/Gaza">Gaza</option>
		<option value="Asia/Harbin">Harbin</option>
		<option value="Asia/Ho_Chi_Minh">Ho Chi Minh</option>
		<option value="Asia/Hong_Kong">Hong Kong</option>
		<option value="Asia/Hovd">Hovd</option>
		<option value="Asia/Irkutsk">Irkutsk</option>
		<option value="Asia/Jakarta">Jakarta</option>
		<option value="Asia/Jayapura">Jayapura</option>
		<option value="Asia/Jerusalem">Jerusalem</option>
		<option value="Asia/Kabul">Kabul</option>
		<option value="Asia/Kamchatka">Kamchatka</option>
		<option value="Asia/Karachi">Karachi</option>
		<option value="Asia/Kashgar">Kashgar</option>
		<option value="Asia/Kathmandu">Kathmandu</option>
		<option value="Asia/Kolkata">Kolkata</option>
		<option value="Asia/Krasnoyarsk">Krasnoyarsk</option>
		<option value="Asia/Kuala_Lumpur">Kuala Lumpur</option>
		<option value="Asia/Kuching">Kuching</option>
		<option value="Asia/Kuwait">Kuwait</option>
		<option value="Asia/Macau">Macau</option>
		<option value="Asia/Magadan">Magadan</option>
		<option value="Asia/Makassar">Makassar</option>
		<option value="Asia/Manila">Manila</option>
		<option value="Asia/Muscat">Muscat</option>
		<option value="Asia/Nicosia">Nicosia</option>
		<option value="Asia/Novokuznetsk">Novokuznetsk</option>
		<option value="Asia/Novosibirsk">Novosibirsk</option>
		<option value="Asia/Omsk">Omsk</option>
		<option value="Asia/Oral">Oral</option>
		<option value="Asia/Phnom_Penh">Phnom Penh</option>
		<option value="Asia/Pontianak">Pontianak</option>
		<option value="Asia/Pyongyang">Pyongyang</option>
		<option value="Asia/Qatar">Qatar</option>
		<option value="Asia/Qyzylorda">Qyzylorda</option>
		<option value="Asia/Rangoon">Rangoon</option>
		<option value="Asia/Riyadh">Riyadh</option>
		<option value="Asia/Sakhalin">Sakhalin</option>
		<option value="Asia/Samarkand">Samarkand</option>
		<option value="Asia/Seoul">Seoul</option>
		<option value="Asia/Shanghai">Shanghai</option>
		<option value="Asia/Singapore">Singapore</option>
		<option value="Asia/Taipei">Taipei</option>
		<option value="Asia/Tashkent">Tashkent</option>
		<option value="Asia/Tbilisi">Tbilisi</option>
		<option value="Asia/Tehran">Tehran</option>
		<option value="Asia/Thimphu">Thimphu</option>
		<option value="Asia/Tokyo">Tokyo</option>
		<option value="Asia/Ulaanbaatar">Ulaanbaatar</option>
		<option value="Asia/Urumqi">Urumqi</option>
		<option value="Asia/Vientiane">Vientiane</option>
		<option value="Asia/Vladivostok">Vladivostok</option>
		<option value="Asia/Yakutsk">Yakutsk</option>
		<option value="Asia/Yekaterinburg">Yekaterinburg</option>
		<option value="Asia/Yerevan">Yerevan</option>
	</optgroup>
	<optgroup label="Atlantic">
		<option value="Atlantic/Azores">Azores</option>
		<option value="Atlantic/Bermuda">Bermuda</option>
		<option value="Atlantic/Canary">Canary</option>
		<option value="Atlantic/Cape_Verde">Cape Verde</option>
		<option value="Atlantic/Faroe">Faroe</option>
		<option value="Atlantic/Madeira">Madeira</option>
		<option value="Atlantic/Reykjavik">Reykjavik</option>
		<option value="Atlantic/South_Georgia">South Georgia</option>
		<option value="Atlantic/St_Helena">St Helena</option>
		<option value="Atlantic/Stanley">Stanley</option>
	</optgroup>
	<optgroup label="Australia">
		<option value="Australia/Adelaide">Adelaide</option>
		<option value="Australia/Brisbane">Brisbane</option>
		<option value="Australia/Broken_Hill">Broken Hill</option>
		<option value="Australia/Currie">Currie</option>
		<option value="Australia/Darwin">Darwin</option>
		<option value="Australia/Eucla">Eucla</option>
		<option value="Australia/Hobart">Hobart</option>
		<option value="Australia/Lindeman">Lindeman</option>
		<option value="Australia/Lord_Howe">Lord Howe</option>
		<option value="Australia/Melbourne">Melbourne</option>
		<option value="Australia/Perth">Perth</option>
		<option value="Australia/Sydney">Sydney</option>
	</optgroup>
	<optgroup label="Europe">
		<option value="Europe/Amsterdam">Amsterdam</option>
		<option value="Europe/Andorra">Andorra</option>
		<option value="Europe/Athens">Athens</option>
		<option value="Europe/Belgrade">Belgrade</option>
		<option value="Europe/Berlin">Berlin</option>
		<option value="Europe/Bratislava">Bratislava</option>
		<option value="Europe/Brussels">Brussels</option>
		<option value="Europe/Bucharest">Bucharest</option>
		<option value="Europe/Budapest">Budapest</option>
		<option value="Europe/Chisinau">Chisinau</option>
		<option value="Europe/Copenhagen">Copenhagen</option>
		<option value="Europe/Dublin">Dublin</option>
		<option value="Europe/Gibraltar">Gibraltar</option>
		<option value="Europe/Guernsey">Guernsey</option>
		<option value="Europe/Helsinki">Helsinki</option>
		<option value="Europe/Isle_of_Man">Isle of Man</option>
		<option value="Europe/Istanbul">Istanbul</option>
		<option value="Europe/Jersey">Jersey</option>
		<option value="Europe/Kaliningrad">Kaliningrad</option>
		<option value="Europe/Kiev">Kiev</option>
		<option value="Europe/Lisbon">Lisbon</option>
		<option value="Europe/Ljubljana">Ljubljana</option>
		<option value="Europe/London">London</option>
		<option value="Europe/Luxembourg">Luxembourg</option>
		<option value="Europe/Madrid">Madrid</option>
		<option value="Europe/Malta">Malta</option>
		<option value="Europe/Mariehamn">Mariehamn</option>
		<option value="Europe/Minsk">Minsk</option>
		<option value="Europe/Monaco">Monaco</option>
		<option value="Europe/Moscow">Moscow</option>
		<option value="Europe/Oslo">Oslo</option>
		<option value="Europe/Paris">Paris</option>
		<option value="Europe/Podgorica">Podgorica</option>
		<option value="Europe/Prague">Prague</option>
		<option value="Europe/Riga">Riga</option>
		<option value="Europe/Rome">Rome</option>
		<option value="Europe/Samara">Samara</option>
		<option value="Europe/San_Marino">San Marino</option>
		<option value="Europe/Sarajevo">Sarajevo</option>
		<option value="Europe/Simferopol">Simferopol</option>
		<option value="Europe/Skopje">Skopje</option>
		<option value="Europe/Sofia">Sofia</option>
		<option value="Europe/Stockholm">Stockholm</option>
		<option value="Europe/Tallinn">Tallinn</option>
		<option value="Europe/Tirane">Tirane</option>
		<option value="Europe/Uzhgorod">Uzhgorod</option>
		<option value="Europe/Vaduz">Vaduz</option>
		<option value="Europe/Vatican">Vatican</option>
		<option value="Europe/Vienna">Vienna</option>
		<option value="Europe/Vilnius">Vilnius</option>
		<option value="Europe/Volgograd">Volgograd</option>
		<option value="Europe/Warsaw">Warsaw</option>
		<option value="Europe/Zagreb">Zagreb</option>
		<option value="Europe/Zaporozhye">Zaporozhye</option>
		<option value="Europe/Zurich">Zurich</option>
	</optgroup>
	<optgroup label="Indian">
		<option value="Indian/Antananarivo">Antananarivo</option>
		<option value="Indian/Chagos">Chagos</option>
		<option value="Indian/Christmas">Christmas</option>
		<option value="Indian/Cocos">Cocos</option>
		<option value="Indian/Comoro">Comoro</option>
		<option value="Indian/Kerguelen">Kerguelen</option>
		<option value="Indian/Mahe">Mahe</option>
		<option value="Indian/Maldives">Maldives</option>
		<option value="Indian/Mauritius">Mauritius</option>
		<option value="Indian/Mayotte">Mayotte</option>
		<option value="Indian/Reunion">Reunion</option>
	</optgroup>
	<optgroup label="Pacific">
		<option value="Pacific/Apia">Apia</option>
		<option value="Pacific/Auckland">Auckland</option>
		<option value="Pacific/Chatham">Chatham</option>
		<option value="Pacific/Chuuk">Chuuk</option>
		<option value="Pacific/Easter">Easter</option>
		<option value="Pacific/Efate">Efate</option>
		<option value="Pacific/Enderbury">Enderbury</option>
		<option value="Pacific/Fakaofo">Fakaofo</option>
		<option value="Pacific/Fiji">Fiji</option>
		<option value="Pacific/Funafuti">Funafuti</option>
		<option value="Pacific/Galapagos">Galapagos</option>
		<option value="Pacific/Gambier">Gambier</option>
		<option value="Pacific/Guadalcanal">Guadalcanal</option>
		<option value="Pacific/Guam">Guam</option>
		<option value="Pacific/Honolulu">Honolulu</option>
		<option value="Pacific/Johnston">Johnston</option>
		<option value="Pacific/Kiritimati">Kiritimati</option>
		<option value="Pacific/Kosrae">Kosrae</option>
		<option value="Pacific/Kwajalein">Kwajalein</option>
		<option value="Pacific/Majuro">Majuro</option>
		<option value="Pacific/Marquesas">Marquesas</option>
		<option value="Pacific/Midway">Midway</option>
		<option value="Pacific/Nauru">Nauru</option>
		<option value="Pacific/Niue">Niue</option>
		<option value="Pacific/Norfolk">Norfolk</option>
		<option value="Pacific/Noumea">Noumea</option>
		<option value="Pacific/Pago_Pago">Pago Pago</option>
		<option value="Pacific/Palau">Palau</option>
		<option value="Pacific/Pitcairn">Pitcairn</option>
		<option value="Pacific/Pohnpei">Pohnpei</option>
		<option value="Pacific/Port_Moresby">Port Moresby</option>
		<option value="Pacific/Rarotonga">Rarotonga</option>
		<option value="Pacific/Saipan">Saipan</option>
		<option value="Pacific/Tahiti">Tahiti</option>
		<option value="Pacific/Tarawa">Tarawa</option>
		<option value="Pacific/Tongatapu">Tongatapu</option>
		<option value="Pacific/Wake">Wake</option>
		<option value="Pacific/Wallis">Wallis</option>
	</optgroup>
</select>
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputTelephone">Téléphonne (Optionnel)</label>
                                <div class="controls">
                                  <input type="number" id="inputTelephone" placeholder="">
                                   <strong class="red-t">* Données Requises</strong>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="inputFax">Fax (Optionnel)</label>
                                <div class="controls">
                                  <input type="number" id="inputFax" placeholder="">
                                 
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
                    </form>
                </div>
  </section>
</section>

