<?php

/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		PAYINVOICE
* @subpackage	Front-end
* @contact		support+payinvoice@readybytes.in
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/** 
 * Invoice Controller
 * @author Gaurav Jain
 */
class PayInvoiceSiteControllerInvoice extends PayInvoiceController
{
	/**
	 * @var PayInvoiceHelperInvoice
	 */
	public $_helper = null;
	
	public function __construct($options = array())
	{
		parent::__construct();
		$this->registerTask( 'cancel', 		'cancel');
	}


	public function ajaxRequestBuildForm()
	{
		$itemid 		= $this->_getId(); 
		$args 			= $this->_getArgs();
		$processor_id 	= $args['processor_id'];		
		$processor 		= PayInvoiceProcessor::getInstance($processor_id);
		$rb_invoice 	= $this->_helper->get_rb_invoice($itemid);
		
		// save the processor configuration
		if($processor_id){
			$rb_invoice['processor_type'] 		= $processor->getType();
			$rb_invoice['processor_config'] 	= $processor->getParams();
			Rb_EcommerceApi::invoice_update($rb_invoice['invoice_id'], $rb_invoice);
		}else {
			$rb_invoice['processor_type'] 		= '';
			$rb_invoice['processor_config'] 	= '';
			Rb_EcommerceApi::invoice_update($rb_invoice['invoice_id'], $rb_invoice);	
			return true;
		}

		$build_data 				= Array();

		$host_string 				= str_replace(JUri::root(true), "", JUri::root());
		$url_string 				= "index.php?option=com_payinvoice&view=invoice&processor={$rb_invoice['processor_type']}";

		$build_data['build_type'] 	= 'html';
		$build_data['notify_url']   = JUri::root().$url_string.'&task=notify&invoice_id='.$itemid;
		$build_data['cancel_url']   = JUri::root().$url_string.'&task=cancel';
		$build_data['return_url']   = JUri::root().$url_string.'&task=complete';

		$this->getView()->assign('response', Rb_EcommerceApi::invoice_request('build', $rb_invoice['invoice_id'], $build_data));
		return true;		
	}
	
	public function paynow()
	{
		$data 			= Rb_Factory::getApplication()->input->post->get('payment_data', array(), 'array');		
		$itemid 		= $this->_getId();
		$rb_invoice 	= $this->_helper->get_rb_invoice($itemid);		
		
		$request_name = 'payment';
		
		$this->_helper->process_payment($request_name, $rb_invoice, $data , $itemid);

		$this->setRedirect(PayInvoiceRoute::_('index.php?option=com_payinvoice&view=invoice&task=complete&invoice_id='.$itemid));
		return false;
	}
	
	public function notify()
	{
		$itemid = $this->_getId();
		
		$get         = Rb_Request::get('GET'); // XITODO :
		$post        = Rb_Request::get('POST');// XITODO :
		$data        = array_merge($get, $post);
		
		$response       	= new stdClass();
		$response->data   	= $data;
		$response->__post  	= $post;
		$response->__get  	= $get; 
		
//		file_put_contents(JPATH_SITE.'/tmp/'.time(), var_export($data,true), FILE_APPEND);		
		
		if(!isset($data['processor'])){
			// raise error				
		}
		
		$processor_type   = $data['processor'];
		$invoice_id 	  = Rb_EcommerceAPI::invoice_get_from_response($processor_type, $response);		
		$response 		  = $this->_helper->process_invoice($invoice_id, $response , $itemid);
	}

	public function display($cachable = false, $urlparams = array())
	{
		$key		= PayInvoiceFactory::getApplication()->input->get('key');
		$itemid 	= $this->getModel()->getId();
	
		// XITODO :: pass invoice as a reference to use in invoice view
		$rb_invoice = $this->_helper->get_rb_invoice($itemid);
		
		if($key != md5($rb_invoice['created_date'])){
		   $this->setTemplate('error');
		   return true;   
		}
		
		return true;
	}
	
	public function complete()
	{
		$itemid = $this->_getId();    

		// XITODO 
  		$notify           = $this->input->get('notify', 0);
   		if ($notify){
			$get         		= Rb_Request::get('GET'); // XITODO :
		    $post        	    = Rb_Request::get('POST');// XITODO :
		    $data        	    = array_merge($get, $post);
                       
	   		$response     		= new stdClass();
			$response->data     = $data;
			$response->__post	= $post;
			$response->__get	= $get;
                      
			//	file_put_contents(JPATH_SITE.'/tmp/'.time(), var_export($data,true), FILE_APPEND);		
		
           	if(!isset($data['processor'])){
            	// raise error                                
           	}
                       
       		$processor_type   = $data['processor'];
         	$invoice_id       = Rb_EcommerceAPI::invoice_get_from_response($processor_type, $response);                
       		$response         = $this->_helper->process_invoice($invoice_id, $response , $itemid);
       	}  
    
		if($itemid <= 0){
  			$invoice_number   	= $this->input->get('invoice_number', '');
  			$rb_invoice_id    	= Rb_EcommerceAPI::invoice_get_id_from_number($invoice_number);
  			$rb_invoice     	= $this->_helper->get_rb_invoice_records(array('invoice_id' => $rb_invoice_id));
  			// XITODO : check rb_invoice had data or not      
  			$rb_invoice     	= array_shift($rb_invoice);
  			$this->getModel()->setState('id', $rb_invoice->object_id);
   		 } 		
   		
		return true;
	}
	
	public function cancel()
	{
		return true;
	}
}