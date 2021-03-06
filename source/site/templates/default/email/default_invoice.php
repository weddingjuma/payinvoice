<?php
/**
* @copyright	Copyright (C) 2009 - 2015 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		PAYINVOICE
* @subpackage	Front-end
* @contact		support+payinvoice@readybytes.in
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<html>
<head>
	<style>
		
	</style>
</head>
<body>
	<div style="background-color:#fff;">
		<table style="font-family: arial;margin: 0px auto;" align="center" width="100%;" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td>
						<table width="100%;" border="0	" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td height="20px" align="center" style="background-color: #222222;">
										<h1 style="color: #FFFFFF;font-family: arial;font-size: 15px;font-weight: bold;letter-spacing: 18px;margin: 0; padding: 5px;"><?php echo $rb_invoice['title'];?></h1>
									</td>
								</tr>
								
								<tr>			
									<td>
										<?php echo $this->loadTemplate('invoice_header');?>
									</td>
								</tr>								
					
								<!-- Items Descriptions -->
								<tr>
									<td style="padding:20px 0px">
										<?php echo $this->loadTemplate('invoice_items');?>
									</td>
								</tr>												
								
								<!-- Footer -->
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0" style="width: 100%;">
											<tbody>
											<tr>
												<?php if($rb_invoice['status'] == PayInvoiceInvoice::STATUS_PAID || $rb_invoice['status'] == PayInvoiceInvoice::STATUS_REFUNDED){?>
													<td><span><strong><?php echo JText::_('COM_PAYINVOICE_COPY_LINK');?></strong><a target="_blank" href="<?php echo $pay_url;?>"><?php echo $pay_url;?></a></span></td>
												<?php } else {?>
														<td><a href="<?php echo $pay_url;?>" style="float: right;font-size: 16px;color: white;border: 1px #0056AE solid;width: 150px;font-weight: 600;background-color: #0056AE;border-radius: 3px;padding: 8px 5px;font-family: arial;text-align: center;text-decoration: none;margin: 0px auto 0px auto;display: block;;"><?php echo JText::_('COM_PAYINVOICE_PAY_NOW');?></a></td>
												<?php }?>
											</tr>
											
										
											</tbody>
										</table>
									</td>
								</tr>						
							</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
 </div>

</body>
</html>
