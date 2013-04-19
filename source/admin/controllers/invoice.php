<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		OSINVOICE
* @subpackage	Back-end
* @contact		team@readybytes.in
*/

// no direct access
if(!defined( '_JEXEC' )){
	die( 'Restricted access' );
}

/** 
 * Invoice Controller
 * @author Gaurav Jain
 */
class OSInvoiceAdminControllerInvoice extends OSInvoiceController
{
	/**
	 * @var OSInvoiceHelperInvoice
	 */
	public $helper = null;
	public function _save(array $data, $itemId=null, $type=null)
	{
		//create new lib instance
		$invoice = Rb_Lib::getInstance($this->_component->getPrefixClass(), $this->getName(), $itemId, $data)
						->save();
		
	   if(!empty($data['params']['processor_id'])){
		    $processor = OSInvoiceProcessor::getInstance($data['params']['processor_id']);
	
		    $data['xiee_invoice']['processor_type']     = $processor->getType();
		    $data['xiee_invoice']['processor_config']   = $processor->getProcessorconfig();
		}
						
		// create invoice in XiEE, in $itemId is null
		if(!$itemId){
			$data['xiee_invoice']['object_type'] 	 = 'OSInvoiceInvoice';
			$data['xiee_invoice']['object_id'] 	 	 = $invoice->getId();
			$data['xiee_invoice']['expiration_type'] = XIEE_EXPIRATION_TYPE_FIXED;
			$data['xiee_invoice']['time_price'] = array('time' => array('000000000000'), 'price' => array('0.00'));
			$invoice_id = XiEEAPI::invoice_create($data['xiee_invoice'], true); 
			$data['xiee_invoice']['invoice_id'] = $invoice_id;
		}	
		else{
			$invoice_id = $data['xiee_invoice']['invoice_id'];
		}
		
		// XITODO : use constants
		$this->helper->create_modifier($invoice_id, 'OSInvoiceItem', $data['subtotal'], 10);
		$this->helper->create_modifier($invoice_id, 'OSInvoiceDiscount', -$data['discount'], 20);
		$this->helper->create_modifier($invoice_id, 'OSInvoiceTax', $data['tax'], 45, true);
		
		$invoice_id = XiEEAPI::invoice_update($invoice_id, $data['xiee_invoice'], true);
		
		return $invoice;
	}
    
    // Show currency symbol in all price fiel when cureency change
	function ajaxchangecurrency()
	{
		$args     	= $this->_getArgs();
		$currency 	= $args['currency'];
		
		$symbol     = OSInvoiceHelperFormat::getCurrency($currency, 'symbol');
				
		$response  = OSInvoiceFactory::getAjaxResponse();
		$response->addScriptCall('osinvoice.jQuery(".osi-currency").html',$symbol);
		$response->sendResponse();
		
	}
	
    // When select user then set currency of user in currency field
	function ajaxchangebuyer()
	{
		$args     	= $this->_getArgs();
		$buyer_id 	= $args['buyer'];
		
		$buyer 		= OSInvoiceBuyer::getInstance($buyer_id);
		$currency   = $buyer->getCurrency();
				
		$response  = OSInvoiceFactory::getAjaxResponse();
		$response->addScriptCall('osinvoice.jQuery("#osinvoice_form_xiee_invoice_currency").val',$currency);
		$response->addScriptCall('osinvoice.admin.invoice.item.on_currency_change', $currency);
		$response->sendResponse();
		
	}
	
	function _remove($itemId=null, $userId=null)
	{
		$filter  = array('object_id' => $itemId); 
		$invoice = XiEEAPI::invoice_get_records($filter, array(), '',$orderby='object_id');
		
		$invoiceId = $invoice[$itemId]->invoice_id;
		
	    XiEEAPI::invoice_delete_record($invoiceId);
	    
	    return parent::_remove();	
		
	}
}
