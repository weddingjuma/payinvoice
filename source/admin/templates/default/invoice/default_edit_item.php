<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		PAYINVOICE
* @subpackage	Back-end
* @contact		team@readybytes.in
*/

// no direct access
if(!defined( '_JEXEC' )){
	die( 'Restricted access' );
}
$component_name = $this->_component->getNameSmall();
?>
<div class="payinvoice-invoice-item">
	<div class="row-fluid">
		<div class="span5"> 
			<textarea name="<?php echo $component_name;?>_form[params][items][##counter##][title]" placeholder="<?php echo Rb_Text::_('COM_PAYINVOICE_INVOICE_EDIT_ITEM_ENTER_NAME_AND_DESCRIPTION');?>">##item_description##</textarea>
		</div>
		<div class="span2">
			<div class="control-group">		
				<input type="text" class="input-small payinvoice-item-quantity validate-number" min="0" name="<?php echo $component_name;?>_form[params][items][##counter##][quantity]"  value="##quantity##" placeholder="<?php echo Rb_Text::_('COM_PAYINVOICE_INVOICE_EDIT_ITEM_QUANTITY');?>">
				<p class="help-block"></p>
			</div>	
		</div>
		<div class="span2">
			<div class="control-group">
				<div class="input-prepend">              			
					<span class="add-on payinvoice-currency"></span>
					<input type="text" class="input-small payinvoice-item-price validate-number" name="<?php echo $component_name;?>_form[params][items][##counter##][price]" value="##price##" placeholder="<?php echo Rb_Text::_('COM_PAYINVOICE_INVOICE_EDIT_ITEM_PRICE_PER_UNIT');?>">						
				</div>
				<p class="help-block"></p>
			</div>
		</div>	
		<div class="span2">
			<div class="input-prepend">              			
				<span class="add-on payinvoice-currency"></span>
				<input type="text" class="input-small payinvoice-item-total" name="<?php echo $component_name;?>_form[params][items][##counter##][total]" value="##total##" readonly="readonly">													
			</div>
		</div>
		<div class="span1"><button type="button" class="btn payinvoice-invoice-item_remove" name="<?php echo $component_name;?>_form_params_items_##counter##_remove"><i class="icon-remove"></i></button></div>
	</div>
	<hr/>
</div>
<?php 