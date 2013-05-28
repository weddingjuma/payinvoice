<?php

/**
 * @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @package 	PAYINVOICE
 * @subpackage	Front-end
 * @contact		team@readybytes.in
 */

// no direct access
if(!defined( '_JEXEC' )){
	die( 'Restricted access' );
}

if(RB_REQUEST_DOCUMENT_FORMAT === 'ajax'){
	class PayInvoiceViewbase extends Rb_ViewAjax{}
}elseif(RB_REQUEST_DOCUMENT_FORMAT === 'json'){
	class PayInvoiceViewbase extends Rb_ViewJson{}
}else{
	class PayInvoiceViewbase extends Rb_ViewHtml{}
}


/** 
 * Base View
 * @author Gaurav Jain
 */
class PayInvoiceView extends PayInvoiceViewbase 
{
	public $_component = PAYINVOICE_COMPONENT_NAME;
	
	public function __construct($config = array())
	{
		parent::__construct($config);
		
		// intialize input
		$this->input = PayInvoiceFactory::getApplication()->input;
		self::addSubmenus(array('dashboard', 'config' , 'processor', 'buyer', 'invoice', 'transaction'));
		
		if(!isset($this->_helper)){
			$this->_helper = $this->getHelper();
		}
		
		return $this;
	}
	
	public function getHelper($name = '')
	{
		if(empty($name)){
			$name = $this->getName();
		}
		
		return PayInvoiceFactory::getHelper($name);
	} 
	
	protected function _adminGridToolbar()
	{
		Rb_HelperToolbar::addNew('new');
		Rb_HelperToolbar::editList();
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::publish();
		Rb_HelperToolbar::unpublish();
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::deleteList();
	}
	
	protected function _adminEditToolbar()
	{
		Rb_HelperToolbar::apply();
		Rb_HelperToolbar::save();
		Rb_HelperToolbar::save2new('savenew');
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::cancel();
	}
	
	protected function _showFooter()
	{
		// avoid ajax request
		if(JRequest::getVar('tmpl')=='component'){
			return '';
		}
		
		//always shown in admin
		if(PayInvoiceFactory::getApplication()->isAdmin()==true){
			return $this->_showAdminFooter();
		}
		
		return '<p align="center">'.Rb_Text::_('COM_PAYINVOICE_POWERED_BY') .'<a id="payinvoicePowerdBy" href="http://www.jpayplans.com/payinvoice" target="_blank" >PayInvoice</a></p>';
	}
	
	
	protected function _showAdminFooter()
	{
		ob_start()?>
       
         	 <div class="powered-by">
				<div class="pull-right muted">
				   <?php echo Rb_Text::_('COM_PAYINVOICE_POWERED_BY') .'<a href="http://www.jpayplans.com/payinvoice" target="_blank" >PayInvoice</a>';?>
				   <?php echo ' | '.Rb_Text::_('COM_PAYINVOICE_FOOTER_VERSION').' <strong>'.PAYINVOICE_VERSION .'</strong> | '. Rb_Text::_('COM_PAYINVOICE_FOOTER_BUILD').PAYINVOICE_REVISION; ?>	  	
			    	<?php echo '<br />'
			    		.Rb_Text::_('COM_PAYINVOICE_FOOTER_MESSAGE')
			    		.'<a href="" target="_blank">'.Rb_Text::_('COM_PAYINVOICE_FOOTER_MESSAGE_JED_LINK').'</a>'
			    	?>
		    	</div>
			</div>
		<?php 
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
