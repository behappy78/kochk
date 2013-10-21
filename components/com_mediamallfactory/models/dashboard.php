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

class MediaMallFactoryFrontendModelDashboard extends JModel
{
  public function getItems()
  {
    $path = JURI::root().'components/com_mediamallfactory/assets/images/dashboard/';

    $items = array(
      'profile',
      'editprofile',
      'parameters',
      //'',
      'purchase' => array('link' => FactoryRoute::view('historypurchases')),
      'favorite' ,
      'invoices' => array('link' => FactoryRoute::view('settings&form=invoices')),
      //'',
      'contacts' => array('link' => FactoryRoute::view('contactsuser'))
    );

    foreach ($items as $item => $options) {
      if ('' == $options) {
        $buttons[] = '';
      } else {
        $key = is_string($options) ? $options : $item;
        if (is_string($options) || !isset($options['link'])) {
          $link = FactoryRoute::view($options);
        } else {
          $link = $options['link'];
        }

        $buttons[$item] = array(
          'view'   => $key,		
          'link'   => $link,
          'image'  => $path . $key .'.png',
          'text'   => FactoryText::_('configuration_button_' . $key),
          'access' => array(),
        );
      }
    }

    return $buttons;
  }

  public function getVersion()
  {
    jimport('joomla.filesystem.file');

    $file = JPATH_COMPONENT_ADMINISTRATOR.DS.'mediamallfactory.xml';

    $data = JApplicationHelper::parseXMLInstallFile($file);

    return $data['version'];
  }

  public function getGateways()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('g.title')
      ->from('#__mediamallfactory_payment_gateways g')
      ->where('g.published = ' . $dbo->quote(1));

    return $dbo->setQuery($query)
      ->loadResultArray();
  }
}
