<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		OSINVOICE
* @subpackage	Front-end
* @contact		team@readybytes.in
*/

// no direct access
if(!defined( '_JEXEC' )){
	die( 'Restricted access' );
}

/** 
 * Params Field
 * @author Gaurav Jain
 */
class OSInvoiceFormFieldParams extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.0
	 */
	public $type = 'Params';

	/**
	 * (non-PHPdoc)
	 * @see libraries/joomla/form/JFormField::getInput()
	 */
	protected function getInput()
	{
		
		if(empty($this->value) || !is_array($this->value)){
			return '';
		}
		
		$html = '';
		foreach ($this->value as $key => $value){
			$html .= '<div class="control-group">';
			$html .= '<div class="control-label">'.$key.'</div>';
			$html .= '<div class="controls">'.$value.'</div>';
			$html .= '</div>';
		}
		
		return $html;
	}
}
