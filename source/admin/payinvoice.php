<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		PAYINVOICE
* @contact		team@readybytes.in
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!defined('RB_FRAMEWORK_LOADED')){
	JLog::add('RB Frameowork not loaded',JLog::ERROR);
}

require_once JPATH_SITE.'/components/com_payinvoice/payinvoice/includes.php';

// find the controller to handle the request
$option	= 'com_payinvoice';
$view	= 'dashboard';
$task	= null;
$format	= 'html';

$controllerClass = PayInvoiceHelper::findController($option,$view, $task,$format);


$controller = PayInvoiceFactory::getInstance($controllerClass, 'controller', 'PayInvoiceadmin');

// execute task
try{
	$controller->execute($task);
}catch(Exception $e){
	PayInvoiceHelper::handleException($e);
}

// lets complete the task by taking post-action
$controller->redirect();
