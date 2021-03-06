<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PAYINVOICE
* @subpackage	Frontend
* @contact 		team@readybytes.in
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class PayInvoiceHelperFormat extends JObject
{
	// XITODO : should not use static function
	public function getCurrency($itemId, $format = null)
	{
		// XITODO : apply caching here: do not ask again is a currnecy is requested previously
	   $currencyId	= array('currency_id' => $itemId);
	   $currencies 	= Rb_EcommerceAPI::currency_get_records($currencyId);
	   
	   if(!isset($format) || $format == 'fullname'){
			return $currencies[$itemId]->title.' ('. $currencies[$itemId]->currency_id .')';
		}
		
		if($format == 'id'){
			return $currencies[$itemId]->currency_id;
		}
		
		if($format == 'symbol'){
			return $currencies[$itemId]->symbol;
		}
		
		return false;
	}
	
	public function date(Rb_Date $date ,$format=null)
	{
		$configHelper	= PayInvoiceFactory::getHelper('config');
		$date_format	= $configHelper->get('date_format');
		$format 		= ($format === null) ? $date_format : $format;

		if(empty($format)){
			return (string)$date;
		}
		
		return $date->toFormat($format);
	}
	
	public function price($amount, $currency, $format = null)
	{
		$currency_symbol = self::getCurrency($currency, $format);
		return $currency_symbol.' '.number_format($amount, 2, '.', '');			
	}
}

