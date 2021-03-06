<?php

/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		PAYINVOICE
* @subpackage	Back-end
* @contact		support+payinvoice@readybytes.in
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/** 
 * Config Html View
 * @author Manisha Ranawat
 */
require_once dirname(__FILE__).'/view.php';
class PayInvoiceAdminViewConfig extends PayInvoiceAdminBaseViewConfig
{	
	public function removelogo()
	{	
		if(!$this->get('confirmed')){
			$this->_confirmDeletelogo($invoice_id);	
		}
		
		$this->_deleteLogo();
	}

    // Confirm delete logo
	public function _confirmDeletelogo($invoice_id)
	{
		$this->_setAjaxWinTitle(JText::_('COM_PAYINVOICE_INVOICE_DELETE_LOGO_WINDOW_TITLE'));
		$this->_setAjaxWinBody(JText::_('COM_PAYINVOICE_INVOICE_DELETE_LOGO_CONFIRM_MESSAGE'));
	
		$this->_addAjaxWinAction(JText::_('COM_PAYINVOICE_CONFIRM'), 'payinvoice.admin.config.deleteLogo.remove();', 'btn btn-success', 'id="payinvoice-invoice-deletelogo-confirm-button"');
		$this->_addAjaxWinAction(JText::_('COM_PAYINVOICE_CLOSE'), 'rb.ui.dialog.close();', 'btn');
		$this->_setAjaxWinAction();		
	
		$ajax = Rb_Factory::getAjaxResponse();
		$ajax->sendResponse();
	}
	
	// Delete logo from configuration 
	public function _deleteLogo()
	{
		$image   				= $this->_helper->get('company_logo');
		$data['company_logo'] 	= '';			
		$extension      		= JFile::getExt($image);		
		$result 				= $this->getHelper('utils')->removeFile(JPATH_ROOT.$image);
       	$model 					= $this->getModel();
		$model->save($data);
		
		$msg = JText::_('COM_PAYINVOICE_LOGO_REMOVED_SUCCESSFULLY');
		if(!$result){
			$msg = JText::_('COM_PAYINVOICE_LOGO_NOT_REMOVED');
		}
		
		$this->_setAjaxWinTitle(JText::_('COM_PAYINVOICE_INVOICE_DELETE_LOGO_WINDOW_TITLE'));
		$this->_setAjaxWinBody($msg);
		
		$this->_addAjaxWinAction(JText::_('COM_PAYINVOICE_CLOSE'), 'rb.ui.dialog.close(); window.location.reload();', 'btn');
		$this->_setAjaxWinAction();		
		
		$ajax = Rb_Factory::getAjaxResponse();
		$ajax->sendResponse();
	}
}
