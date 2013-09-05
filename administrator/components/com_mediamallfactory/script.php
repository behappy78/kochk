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

class com_MediaMallFactoryInstallerScript
{
  public function install($parent)
  {
  }

  public function uninstall($parent)
  {
  }

  public function update($parent)
  {
  }

  public function preflight($type, $parent)
  {
  }

  public function postflight($type, $parent)
  {
    if ('install' == $type) {
      $this->setDefaultSettings();
    }
  }

  protected function setDefaultSettings()
  {
    // Import default settings
    $extension = JTable::getInstance('Extension', 'JTable');
    $result = $extension->find(array('element' => 'com_mediamallfactory', 'type' => 'component'));
    $extension->load($result);

    $params = '{"invoices":{"invoice":{"template":"<table class=\"no_border\" style=\"width: 100%;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td class=\"no_padding\" style=\"width: 250px; vertical-align: top;\">\r\n<table style=\"width: 100%;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td class=\"billing_information\" valign=\"top\">Seller Information<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class=\"header\">Contact Details<\/td>\r\n<\/tr>\r\n<tr>\r\n<td>%%seller_information%%<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<\/td>\r\n<td style=\"text-align: center;\" valign=\"bottom\">\r\n<p><span style=\"font-size: xx-large;\"><strong>Invoice<\/strong><\/span><\/p>\r\n<p>\u00a0<\/p>\r\n<p>Number: <strong>%%invoice_number%%<\/strong><\/p>\r\n<p>Date: <strong>%%invoice_date%%<\/strong><\/p>\r\n<\/td>\r\n<td class=\"no_padding\" style=\"width: 250px; vertical-align: top;\">\r\n<table style=\"width: 100%;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td class=\"billing_information\">Buyer Information<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class=\"header\">Contact Details<\/td>\r\n<\/tr>\r\n<tr>\r\n<td>%%buyer_information%%<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>\u00a0<\/p>\r\n<table style=\"width: 100%;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td class=\"billing_information\" colspan=\"3\">Billing Information<\/td>\r\n<\/tr>\r\n<tr>\r\n<td class=\"header\">Credits<\/td>\r\n<td class=\"header\">\u00a0<\/td>\r\n<td class=\"header\" style=\"width: 100px;\">Price<\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"text-align: left;\">%%item_title%%<\/td>\r\n<td style=\"text-align: right;\">\u00a0<\/td>\r\n<td style=\"text-align: left;\">%%amount%%<\/td>\r\n<\/tr>\r\n<tr>\r\n<td>\u00a0<\/td>\r\n<td style=\"text-align: right;\"><strong>VAT<\/strong><\/td>\r\n<td style=\"text-align: left;\">%%vat%%<\/td>\r\n<\/tr>\r\n<tr>\r\n<td>\u00a0<\/td>\r\n<td style=\"text-align: right;\"><strong>TOTAL<\/strong><\/td>\r\n<td style=\"text-align: left;\">%%total%%<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p style=\"text-align: center;\">\u00a0<\/p>\r\n<p style=\"text-align: center;\"><strong>www.yoursite.com<\/strong><\/p>\r\n<p style=\"text-align: center;\">Lorem ipsum dolor sit amet.Suspendisse potenti. Phasellus volutpat.<\/p>"},"seller":{"template":"<p>Media Mall Factory<\/p>"},"buyer":{"template":"<p>%%name%%,<\/p>\r\n<p>%%address%%,<\/p>\r\n<p>%%city%%, %%country%%<\/p>"}}}';

    $extension->params = $params;

    return $extension->store();
  }
}
