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
	public $_helper = null;
	public function _save(array $data, $itemId=null, $type=null)
	{
		// If Serial number already exist then do nothing
		$serial_exist	= $this->_helper->exist_serial_number($data['rb_invoice']['serial']);
		if(!$itemId && $serial_exist){
			return true;
		}
		//create new lib instance
		$invoice = Rb_Lib::getInstance($this->_component->getPrefixClass(), $this->getName(), $itemId, $data)
						->save();
		
	   if(!empty($data['params']['processor_id'])){
		    $processor = OSInvoiceProcessor::getInstance($data['params']['processor_id']);
	
		    $data['rb_invoice']['processor_type']     = $processor->getType();
		    $data['rb_invoice']['processor_config']   = $processor->getParams();
		}
						
		// create invoice in Rb_Ecommerce, in $itemId is null
		if(!$itemId){
			$data['rb_invoice']['object_type'] 	 = 'OSInvoiceInvoice';
			$data['rb_invoice']['object_id'] 	 	 = $invoice->getId();
			$data['rb_invoice']['expiration_type'] = RB_EXPIRATION_TYPE_FIXED;
			$data['rb_invoice']['time_price'] = array('time' => array('000000000000'), 'price' => array('0.00'));
			$invoice_id = Rb_EcommerceAPI::invoice_create($data['rb_invoice'], true); 
			$data['rb_invoice']['invoice_id'] = $invoice_id;
		}	
		else{
			$invoice_id = $data['rb_invoice']['invoice_id'];
		}
		
		// XITODO : use constants
		$this->_helper->create_modifier($invoice_id, 'OSInvoiceItem', $data['subtotal'], 10);
		$this->_helper->create_modifier($invoice_id, 'OSInvoiceDiscount', -$data['discount'], 20);
		$this->_helper->create_modifier($invoice_id, 'OSInvoiceTax', $data['tax'], 45, true);
		
		$invoice_id = Rb_EcommerceAPI::invoice_update($invoice_id, $data['rb_invoice'], true);
		
		return $invoice;
	}
    
    // Show currency symbol in all price fiel when cureency change
	function ajaxchangecurrency()
	{
		$args     	= $this->_getArgs();
		$currency 	= $args['currency'];
		
		$format		 = $this->getHelper('format');
		$symbol		 = $format->getCurrency($currency, 'symbol');
				
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
		$response->addScriptCall('osinvoice.jQuery("#osinvoice_form_rb_invoice_currency").val',$currency);
		$response->addScriptCall('osinvoice.admin.invoice.item.on_currency_change', $currency);
		$response->sendResponse();
		
	}
	
	function _remove($itemId=null, $userId=null)
	{
		$filter  = array('object_id' => $itemId); 
		$invoice = Rb_EcommerceAPI::invoice_get_records($filter, array(), '',$orderby='object_id');
		
		$invoiceId = $invoice[$itemId]->invoice_id;
		
	    Rb_EcommerceAPI::invoice_delete_record($invoiceId);
	    
	    return parent::_remove($itemId, $userId);	
		
	}
	
	public function email()
	{
		return true;
	}

	// Check serial number is already exist or not
	function ajaxchangeserial()
	{
		$args     			= $this->_getArgs();
		$invoice_serial 	= $args['serial'];
	
		$serial				= $this->_helper->exist_serial_number($invoice_serial);
		$response 		    = OSInvoiceFactory::getAjaxResponse();
		if($serial){	
			$response->addScriptCall('osinvoice.jQuery("span.invoice-error").html',Rb_Text::_('COM_OSINVOICE_INVOICE_SERIAL_ALREADY_EXIST'));
			$response->addScriptCall('osinvoice.jQuery("#osinvoice_form_rb_invoice_serial").focus()');
		}else {
			$response->addScriptCall('osinvoice.jQuery("span.invoice-error").html', "");
		}
		$response->sendResponse();
	}
}
