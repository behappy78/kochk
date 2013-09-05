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

class MediaMallFactoryBackendModelInvoice extends JModel
{
  public function getItem($pk = null)
  {
    static $items = array();

    if (is_null($pk)) {
      $pk = JFactory::getApplication()->input->getInt('invoice_id', 0);
    }

    if (!isset($items[$pk])) {
      $table = FactoryTable::getInstance('Invoice');
      $table->load($pk);

      $items[$pk] = $table;
    }

    return $items[$pk];
  }

  public function getTemplate()
  {
    $template = FactoryApplication::getInstance()->getParam('invoices.invoice.template', '');
    $item     = $this->getItem();

    if (!$item) {
      return false;
    }

    $search = array(
      '%%seller_information%%',
      '%%buyer_information%%',
      '%%invoice_number%%',
      '%%invoice_date%%',
      '%%item_title%%',
      '%%amount%%',
      '%%vat%%',
      '%%total%%',
    );

    $replace = array(
      $item->params->get('seller_information', 'Seller Information'),
      $item->params->get('buyer_information', 'Buyer Information'),
      $item->id,
      JHtml::_('date', $item->created_at),
      $item->title,
      ($item->amount - $item->vat_value) . ' ' . $item->currency,
      $item->vat_value . ' ' . $item->currency,
      $item->amount . ' ' . $item->currency
    );

    $template = str_replace($search, $replace, $template);

    return $template;
  }

  public function delete($batch)
  {
    JArrayHelper::toInteger($batch);

    if (!$batch) {
      $this->setError(FactoryText::_('list_empty'));
      return false;
    }

    foreach ($batch as $id) {
      $table = $this->getTable();

      if (!$table->load($id)) {
        $this->setError($table->getError());
        return false;
      }

      if (!$table->delete()) {
        $this->setError($table->getError());
        return false;
      }
    }

    return true;
  }

  public function getTable($type = 'Invoice')
  {
    return FactoryTable::getInstance($type);
  }
}
