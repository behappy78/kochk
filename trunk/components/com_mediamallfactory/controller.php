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

jimport('joomla.application.component.controller');

class MediaMallFactoryFrontendController extends JController
{
  protected $default_view = 'list';
  function __construct($config)
  {
        $jinput = JFactory::getApplication()->input;
        $session =& JFactory::getSession();
        $format = $jinput->get->get('format', 'html');
        $view = $jinput->get->get('view', '');
        
        if ($format == 'html' && $session->has('step'))
            $session->clear('step');
        else 
        {
          if($view != 'ajax')
          {
              $data    = JRequest::get( 'post' );
              $step = $session->get('step');
              //echo $step; 
              //die();
                  if ($step == 1)
                {
                    //die();
                    $confcode = uniqid();
                    $mailer = JFactory::getMailer();
                    $sender = array( 
                        'feki.hichem@gmail.com',
                        'Kochk' );
                    $mailer->setSender($sender);
                    $recipient = $data['inputEmail'];
                    $mailer->addRecipient($recipient);
                    $body   = '<h2>Confirmation email</h2>'
                        . '<div>Confirmation code: '.$confcode
                        . '<img src="cid:logo_id" alt="logo"/></div>';
                    $mailer->isHTML(true);
                    $mailer->Encoding = 'base64';
                    $mailer->setBody($body);
                    // Optionally add embedded image
                    $mailer->AddEmbeddedImage( JPATH_COMPONENT.'/assets/logo128.jpg', 'logo_id', 'logo.jpg', 'base64', 'image/jpeg' );
                    $send = $mailer->Send();
                    if ( $send !== true ) {
                        echo 'Error sending email: ' . $send->get('message');
                    } else {
                        echo 'Mail sent'.$recipient.' '.$body;
                    }
                }
          }             
        }
        parent::__construct($config);   
  }
  
}
