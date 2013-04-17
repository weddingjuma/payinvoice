<?php 
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		OSINVOICE
* @subpackage	Backend
* @contact 		team@readybytes.in
*/

if(defined('_JEXEC')===false) die();

JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">

(function($){
	$(document).ready(function(){
       $('#osinvoice-delete-logo').click(function(){
               var args   = { };
               var url = 'index.php?option=com_osinvoice&view=config&task=removelogo';
               osinvoice.ajax.go(url, args);
               return false;
       });
	});
})(osinvoice.jQuery);

	Joomla.submitbutton = function(task)
	{	
		if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	}	

</script>

<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">	
  <fieldset class="form-horizontal">
  	<div class="span6">	
			<h3> <?php echo Rb_Text::_('COM_OSINVOICE_CONFIG_BASIC_SETTING' ); ?> </h3><hr>	
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('currency'); ?> </div>
				<div class="controls"><?php echo $form->getInput('currency'); ?></div>								
			</div>	
	  
	</div>				
			
		<div class="span6">
			<h3> <?php echo Rb_Text::_('COM_OSINVOICE_CONFIG_COMPANY_SETTINGS' ); ?> </h3><hr>	
				
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('company_logo'); ?> </div>
				<div class="controls">
					<div id="osinvoice-logo-image"><img src="<?php echo Rb_HelperTemplate::mediaURI($config_data['company_logo'], false);; ?>" /></div>
					<?php echo $form->getInput('company_logo'); ?>
					<div><a href="#" id="osinvoice-delete-logo" class="span3">Delete</a></div>
				</div>								
			</div>
			
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('company_name'); ?> </div>
				<div class="controls"><?php echo $form->getInput('company_name'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('company_address'); ?> </div>
				<div class="controls"><?php echo $form->getInput('company_address'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('company_city'); ?> </div>
				<div class="controls"><?php echo $form->getInput('company_city'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('company_phone'); ?> </div>
				<div class="controls"><?php echo $form->getInput('company_phone'); ?></div>								
			</div>			
	</div>
</fieldset>
	
	<input type="hidden" name="task" value="save" />
</form>
<?php 
