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
$link = $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=registration");
$link1 = $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=ajax&format=raw");
$url=JRoute::_(JURI::base());//."index.php?option=com_mediamallfactory&view=list");
// Add Javascript

$document->addScriptDeclaration("
	function FValidator(validate){
		Locale.use('fr-FR');
    	var myForm = document.id('adminForm');
  		myForm.getElements('[type=password], [type=text], textarea').each(function(el){
    		//new OverText(el);
 		});
        myFormValidator = new Form.Validator.Inline(myForm, {
        	  stopOnFailure: true, 
              useTitles: true,
              serial: false,
              errorPrefix: '',
              onFormValidate: function(passed, form, event) {
                 if (passed) {
                    //form.submit();
                 }
              }
           });
   		var myurl = '".$link1."&layout=ajax&tmpl=component';
   
        myFormValidator.add('emailUnique', {
           errorMsg: 'E-Mail address is already registered',
           test: function(element, props) {
              if (element.value.length > 0) {
                 var req = new Request({
                    url: myurl+'&src=email',
                    async: false
                 }).send('data=' + element.value);
                 //alert (req.response.text);
                 return (req.response.text != '1');
                 
              }
              return true;
           }
        });

        myFormValidator.add('loginUnique', {
           errorMsg: 'login is already taken',
           test: function(element, props) {
              if (element.value.length > 0) {
                 var req = new Request({
                    url: myurl+'&src=login',
                    async: false
                 }).send('data=' + element.value);
                 //alert (req.response.text);
                 return (req.response.text != '1');
                 
              }
              return true;
           }
        });
        myFormValidator.add('mailCode', {
           errorMsg: 'Code invalide',
           test: function(element, props) {
              if (element.value.length > 0) {
                 var req = new Request({
                    url: myurl+'&src=mailcode',
                    async: false
                 }).send('data=' + element.value);
                 //alert (req.response.text);
                 return (req.response.text != '1');
                 
              }
              return true;
           }
        });
		if (validate)
		{
			return myFormValidator.validate()
		}
	};
");
$document->addScriptDeclaration("
	window.addEvent('domready', function(){
		FValidator(false);
	});
");
$document->addScriptDeclaration("
	function submitFormK(e) {
		theform = document.id('adminForm');
		var validator = new Form.Validator.Inline(theform);
   		var myurl = '".$link1."&layout=ajax&tmpl=component';
		if (e != 2 && e!= 0)
		{
			
			if (!FValidator(true))
				return false;
		}
		if (e == 0)
		{
            var req = new Request({
            url: myurl+'&src=reset',
            async: false
            }).send();
            //alert (req.response.text);
            location.href='".$url."';
            return false;
		}
		document.id('step').value = e;
		kochkmain = document.id('kochkmain');
		kochkmain.set('tween', {duration: 1000, link:'chain', property:'opacity'});
		myFX = new Fx.Tween('kochkmain', { duration: 1000, property: 'opacity'});
		var mySpin = new Spinner('kochkmain');
		mySpin.show();
        theform.set('send', {
			onComplete: function(response) {
    		    myFX.start.pass([1,0], myFX);
    			setTimeout(function() { 
    				kochkmain.set('html', response);
    				myFX.start.pass([0,1], myFX); 
    			},1000);
    			setTimeout(function() { 
    				mySpin.hide();
    				FValidator(false);
    			},1500);
			}
		});
		theform.send();
	};
");
$session = JFactory::getSession();
$step = $session->get('step');
echo $step;
$stepD = $session->get('stepD'); 
$maxSteps = (int)$session->get('maxSteps_');
if ($step != 3)
	$link .= "&format=raw";
?>
    <form action="<?php echo $link ?>" id="adminForm" name="adminForm" method="post" class="form-validate form-horizontal">
<div <?php if ($step == $stepD) echo 'id="kochkmain"';?> >
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="step" id="step" value="" />
    <?php echo JHtml::_('form.token'); ?>

 <div class="heading-bar">
  <h2><?php echo FactoryText::_('register_page_title'); ?></h2>
   <span class="h-line"></span> </div>
<!-- Start Main Content -->
<section class="register-holder">
  <section class="span12 first">
    <?php echo $this->loadTemplate($step);
     $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=list");
    ?>
        </section>
</section>
	<?php 
    if ($step == $stepD)
    echo '</div>';
	?>
  </form>