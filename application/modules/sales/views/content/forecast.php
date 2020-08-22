<?php

$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Sales.Content.Delete');
$can_edit		= $this->auth->has_permission('Sales.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
	$num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('forecast_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
	<table class='table table-striped'>
		<thead>
			<tr>
				<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
				<?php endif; ?>

				<th><?php echo lang('forecast_field_bp_id'); ?></th>
				<th><?php echo lang('forecast_field_model_id'); ?></th>
				<th><?php echo lang('forecast_field_item_id'); ?></th>
				<th><?php echo lang('forecast_field_cust_part'); ?></th>
				<th><?php echo lang('forecast_field_fy'); ?></th>
				<th><?php echo lang('forecast_field_period'); ?></th>
				<th><?php echo lang('forecast_field_sales_qty'); ?></th>
			</tr>
		</thead>
		<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
					<tr>
						<td colspan='<?php echo $num_columns; ?>'>
							<?php echo lang('bf_with_selected'); ?>
							<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('forecast_delete_confirm'))); ?>')" />
						</td>
					</tr>
				<?php endif; ?>
			</tfoot>
		<?php endif; ?>
		<tbody>
			<?php
			if ($has_records) :
				foreach ($records as $record) :
			?>
					<tr>
						<?php if ($can_delete) : ?>
							<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
						<?php endif; ?>

						<td><?php e($record->bp_id); ?></td>
						<td><?php e($record->model_id); ?></td>
						<?php if ($can_edit) : ?>
							<td><?php echo anchor(SITE_AREA . '/content/sales/edit_forecast/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->item_id); ?></td>
						<?php else : ?>
							<td><?php e($record->item_id); ?></td>
						<?php endif; ?>
						<td><?php e($record->cust_part); ?></td>
						<td><?php e($record->fy); ?></td>
						<td><?php e($record->period); ?></td>
						<td><?php e($record->sales_qty); ?></td>
					</tr>
				<?php
				endforeach;
			else :
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('forecast_records_empty'); ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<?php
	echo form_close();

	echo $this->pagination->create_links();
	?>
</div>