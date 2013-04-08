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
 * Invoice Html View
 * @author Gaurav Jain
 */
require_once dirname(__FILE__).'/view.php';
class OSInvoiceAdminViewInvoice extends OSInvoiceAdminBaseViewInvoice
{	
	function edit($tpl= null, $itemId = null)
	{
		$itemId  = ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		$invoice = OSInvoiceInvoice::getInstance($itemId);
		$form 	 = $invoice->getModelform()->getForm($invoice);

		$this->assign('invoice', $invoice);
		$this->assign('form',  $form);
		
		if($itemId){
			$xiee_invoice = XiEEAPI::invoice_get(array('object_type' => 'OSInvoiceInvoice', 'object_id' => $itemId));			
			$form->bind(array('xiee_invoice' => $xiee_invoice)); 
		}		
		
		$xiee_invoice_fieldset = $form->getFieldset('xiee_invoice');
		$xiee_invoice_fields = array();
		foreach ($xiee_invoice_fieldset as $field){
			$xiee_invoice_fields[$field->fieldname] = $field;
		}
		
		$this->assign('xiee_invoice_fields', $xiee_invoice_fields);
		return true;
	}
}