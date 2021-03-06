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
 * Processor Type Html Element
 * @author Gaurav Jain
 */

class PayInvoiceHtmlProcessortypes
{
	static function edit($name, $value, $attr=null, $ignore=array())
	{
		$processor_data = Rb_EcommerceAPI::get_processors_list();		
		
		$options = array();
		if(isset($attr['none']))
			$options[] = PayInvoiceHtml::_('select.option', '', JText::_('COM_PAYINVOICE_PROCESSOR_SELECT_PROCESSOR_TYPE'));
			
		foreach($processor_data  as $type => $data){
			$options[] = PayInvoiceHtml::_('select.option', $type, JString::ucfirst($type));	
		}

		$style = isset($attr['style']) ? $attr['style'] : '';
		return PayInvoiceHtml::_('select.genericlist', $options, $name, $style, 'value', 'text', $value);
	}
}
