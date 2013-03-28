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
 * Buyer Controller
 * @author Gaurav Jain
 */
class OSInvoiceAdminControllerBuyer extends OSInvoiceController
{
	public function _save(array $data, $itemId=null, $type=null)
	{
		if(empty($data['username'])){
		   $data['username'] = $data['email'];
		}

		return parent::_save($data, $itemId, $type);
	}	
}
