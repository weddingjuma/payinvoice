<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		OSINVOICE
* @subpackage	Frontend
* @contact 		team@readybytes.in
*/
if(defined('_JEXEC')===false) die();
class OSInvoiceHelperUtils extends JObject
{
	function saveUploadedFile($storagepath='',$filepath='',$filename='',$supportedExtensions=array(),$savedname="default")
	{
		//no file selected then do nothing
		if(empty($filepath))
		{
		  	return false;
		}
	
		$app = OSInvoiceFactory::getApplication();
	
		//remove backslashes from file name
		$filename = stripslashes($filename);

		//get file extension
	   	$extension = strtolower(JFile::getExt($filename));	

	  	//check if file has supported extensions or not
		if(!in_array($extension, $supportedExtensions))
		{
			$app->enqueueMessage(Rb_Text::_('COM_OSINVOICE_CONFIG_CUSTOMIZATION_EDIT_EXTENSION_NOT_SUPPORTED'));
			return false;
		}

		//check if folder exist or not. If not exists then create it.
		if(JFolder::exists(JPATH_ROOT.$storagepath)==false){
			JFolder::create(JPATH_ROOT.$storagepath);
		}
		
		//select the path for image storage
		$imgname = JPATH_ROOT.$storagepath.$savedname.'.'.$extension;
		 
		$img1= $storagepath.$savedname.'.'.$extension;
		copy($filepath, $imgname);
	
		return $img1;
	}
	
	static function removeFile($file)
	{
		if(JFile::exists($file)){
			return JFile::delete($file);
		}
	}	
}