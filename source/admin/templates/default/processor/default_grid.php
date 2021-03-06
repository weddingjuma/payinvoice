<?php
/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package 		PAYINVOICE
* @subpackage	Back-end
* @contact		support+payinvoice@readybytes.in
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<form action="<?php echo $uri; ?>" method="post" id="adminForm" name="adminForm">
	<table class="table table-hover">
			<thead>
				<!-- TABLE HEADER START -->
				<tr>
					<th  width="1%" class="hidden-phone">
						<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
					</th>
					<th class="default-grid-sno hidden-phone">
						<?php echo PayInvoiceHtml::_('grid.sort', "COM_PAYINVOICE_PROCESSOR_ID", 'processor_id', 	$filter_order_Dir, $filter_order);?>
					</th>
					<th><?php echo PayInvoiceHtml::_('grid.sort', "COM_PAYINVOICE_PROCESSOR_TITLE", 'title', 	$filter_order_Dir, $filter_order);?></th>
					<th><?php echo PayInvoiceHtml::_('grid.sort', "COM_PAYINVOICE_PROCESSOR_TYPE", 'type', 	$filter_order_Dir, $filter_order);?></th>
					<th><?php echo PayInvoiceHtml::_('grid.sort', "COM_PAYINVOICE_PUBLISHED", 'published', $filter_order_Dir, $filter_order);?></th>
				</tr>
			<!-- TABLE HEADER END -->
			</thead>
		
			<tbody>
			<?php $count= $limitstart;
			  foreach ($records as $record):?>
				<tr class="<?php echo "row".$count%2; ?>">
				<?php if(isset($processor_names[$record->type])) :?>	 
				    <th class="default-grid-chkbox nowrap hidden-phone">
				    	<?php echo PayInvoiceHtml::_('grid.id', $count, $record->{$record_key} ); ?>
				    </th>
					<td class="nowrap hidden-phone"><?php echo $record->processor_id; ?> </td>	
					<td><?php echo PayInvoiceHtml::link($uri.'&task=edit&id='.$record->{$record_key}, $record->title); ?>
						 <p class="muted"><?php echo $record->description;?></p>
					</td>	
					<td><?php echo $record->type;?></td>						
					<td><?php echo PayInvoiceHtml::_("rb_html.boolean.grid", $record, 'published', $count, 'tick.png', 'publish_x.png', '', $langPrefix='COM_PAYINVOICE');?></td>
			   <?php else :?>
        			 <th class="default-grid-chkbox"></th>
					<td><?php echo $count+1; ?> </td>	
					<td><?php echo $record->title;?>
						<p class="muted"><?php echo $record->description;?></p>
					</td>
    				<td colspan="3"><?php echo sprintf(JText::_('COM_PAYINVOICE_PROCESSOR_GRID_PROCESSOR_PLUGIN_DISABLE'), $record->type);?></td>	
			   <?php endif;?>
			
			<?php $count++;?>		
			<?php endforeach;?>
			</tbody>
  		</table>
  
  		<div class="row">
     		<div class="offset5 span7"><?php echo $pagination->getListFooter();?></div>
   		</div> 
   		
		<input type="hidden" name="filter_order" value="<?php echo $filter_order;?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $filter_order_Dir;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
	</form>
