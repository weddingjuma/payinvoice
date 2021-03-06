<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		PAYINVOICE
* @subpackage	Front-end
* @contact		team@readybytes.in
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/** 
 * Transation Lib
 * @author Manisha Ranawat
 */
class PayInvoiceProcessor extends PayInvoiceLib
{	
	protected $processor_id 	= 0;
	protected $title        	= '';
	protected $description 	 	= '';
	protected $type 			= '';
	protected $published        = 1;
    protected $params           = null;
	
	public function reset()
	{		
		$this->processor_id 		= 0;
		$this->title                = '';
		$this->description          = '';
		$this->type       			= '';
		$this->published            = 1;
		$this->params 				= new Rb_Registry();
		
		return $this;
	}
	
	/**
	 * @return PayInvoiceProcessor
	 */
	public static function getInstance($id = 0, $data = null, $dummy1 = null, $dummy2 = null)
	{
		return parent::getInstance('processor', $id, $data);
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getParams($object = true, $default = null, $property='params')
	{
		if($object){
			return $this->params->toObject();
		}
		
		return $this->params->toArray();
	} 
}
