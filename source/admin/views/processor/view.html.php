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
 * Transaction Html View
 * @author Manisha Ranawat
 */
require_once dirname(__FILE__).'/view.php';
class PayInvoiceAdminViewProcessor extends PayInvoiceAdminBaseViewProcessor
{	
	protected function _adminGridToolbar()
	{
		$task = PayInvoiceFactory::getApplication()->input->get('task', '');
		if($task == 'selectProcessor'){
			JToolbarHelper::back('COM_PAYINVOICE_JS_BACK', 'index.php?option=com_payinvoice&view=processor');
		}else {
			JToolbarHelper::addNew('selectProcessor');
			JToolbarHelper::editList();
			JToolbarHelper::divider();
			JToolbarHelper::publish();
			JToolbarHelper::unpublish();
			JToolbarHelper::divider();
			JToolbarHelper::deleteList(JText::_('COM_PAYINVOICE_JS_ARE_YOU_SURE_TO_DELETE'));
		}
	}
	
	protected function _adminEditToolbar()
	{	
		JToolbarHelper::apply();
		JToolbarHelper::save();
		JToolbarHelper::divider();
		JToolbarHelper::cancel();
	}
	
	function _displayGrid($records)
	{	
		$this->assign('processor_names',  Rb_EcommerceAPI::get_processors_list());
		return parent::_displayGrid($records);
	}
	
	function edit($tpl= null, $itemId = null, $processor_type= null)
	{
		$itemId  		=  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;		
		$processorType 	=  PayInvoiceProcessor::getInstance($itemId);
		
		if(!$itemId){
			$processor_type = $this->input->get('processor_type', $processor_type);
			if(!$processor_type){
				$message	= JText::_('COM_PAYINVOICE_NO_PROCESSOR_TYPE');
				PayInvoiceFactory::getApplication()->redirect('index.php?option=com_payinvoice&view=processor&task=selectProcessor', $message, 'error');
			}
			$processorType->set('type',$processor_type);
		}
		
		$help  	   =  $this->getHelper('processor')->getXml($processorType->getType());
				
		$this->assign('processor', $processorType);
		$this->assign('form',  $processorType->getModelform()->getForm($processorType));
		$this->assign('help', $help);
		
		return true;
	}
	
	public function selectProcessor()
	{
		$processors = Rb_EcommerceAPI::get_processors_list();
		$this->assign('processors', $processors);
		
		$this->setTpl('select_processor');
		return true;
	}
}
