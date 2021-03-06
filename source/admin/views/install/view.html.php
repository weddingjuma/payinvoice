<?php
/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayInvoice
* @subpackage	Backend
* @contact 		support+payinvoice@readybytes.in
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

include_once dirname(__FILE__).'/view.php';

class PayInvoiceAdminViewInstall extends PayInvoiceAdminBaseViewInstall
{

	protected function _adminToolbar()
	{
		$this->_adminToolbarTitle();
	}
	
	public function _basicFormSetup($task)
	{
		return true;
	}

	public function display($tpl=null)
	{
		$app 		= PayInvoiceFactory::getApplication();
		$db_prefix 	= $app->input->get('dbprefix', '');
		$db 		= PayInvoiceFactory::getDbo();
		$tables 	= $db->getTableList();
		$email 		= '';
		
		if (!in_array($db_prefix.'rbinstaller_config', $tables)){
			$this->assign('email', $email);
			return true;
		}
		
		$query	= 'SELECT * FROM `#__rbinstaller_config`'
				  .'WHERE `key` = "email"';
		
		$db->setQuery($query);
		
		$object = $db->loadObject();
		if($object){
			$email = $object->value;
		}
		
		$this->assign('email', $email);
		return true;
	}
}
