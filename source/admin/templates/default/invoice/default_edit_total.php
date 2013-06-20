<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		PAYINVOICE
* @subpackage	Back-end
* @contact		team@readybytes.in
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!-- START : Total -->
<fieldset class="form-horizontal">
	<div class="span6">
	</div>
	
	<div class="span6">
		<div class="control-group">
			<label class="control-label"><?php echo Rb_Text::_('COM_PAYINVOICE_INVOICE_EDIT_ITEM_SUBTOTAL');?></label>
	  		<div class="controls">
	  			<div class="input-prepend">              			
					<span class="add-on payinvoice-currency"></span>
					<input type="text" name="payinvoice_form[subtotal]" class="input-small" readonly="readonly" id="payinvoice-invoice-subtotal">		
				</div>
	  		</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?php echo Rb_Text::_('COM_PAYINVOICE_INVOICE_EDIT_ITEM_DISCOUNT');?></label>
	  		<div class="controls">
	  			<div class="input-prepend">
					<span class="add-on payinvoice-currency"></span>
					<input type="text" name="payinvoice_form[discount]" class="input-small validate-number" min="0" id="payinvoice-invoice-discount" value="<?php echo $discount;?>">
				</div>
	  		</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?php echo Rb_Text::_('COM_PAYINVOICE_INVOICE_EDIT_ITEM_TAX');?></label>
	  		<div class="controls">
	  			<div class="input-append">									
					<input type="text" name="payinvoice_form[tax]" class="input-small validate-number" id="payinvoice-invoice-tax" min="0" value="<?php echo $tax;?>">
					<span class="add-on">%</span>
				</div>
	  		</div>
		</div>
		<hr>
		<div class="control-group">
			<label class="control-label"><?php echo Rb_Text::_('COM_PAYINVOICE_INVOICE_EDIT_ITEM_TOTAL');?></label>
	  		<div class="controls">
	  			<div class="input-prepend">
					<span class="add-on payinvoice-currency"></span>
					<input type="text" name="payinvoice_form[total]" class="input-small" readonly="readonly" id="payinvoice-invoice-total" min="0">
				</div>
	  		</div>
		</div>
	</div>
</fieldset>
<?php 