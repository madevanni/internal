<?php

$num_columns	= 11;
$can_delete	= $this->auth->has_permission('Planning.Content.Delete');
$can_edit		= $this->auth->has_permission('Planning.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
	$num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('calendar_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
	<table class='table table-striped'>
		<thead>
			<tr>
				<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
				<?php endif; ?>
				<th><?php echo lang('calendar_field_db_date'); ?></th>
				<th><?php echo lang('calendar_field_year'); ?></th>
				<th><?php echo lang('calendar_field_month'); ?></th>
				<th><?php echo lang('calendar_field_day'); ?></th>
				<th><?php echo lang('calendar_field_quarter'); ?></th>
				<th><?php echo lang('calendar_field_week'); ?></th>
				<th><?php echo lang('calendar_field_day_name'); ?></th>
				<th><?php echo lang('calendar_field_month_name'); ?></th>
				<th><?php echo lang('calendar_field_holiday_flag'); ?></th>
				<th><?php echo lang('calendar_field_weekend_flag'); ?></th>
				<th><?php echo lang('calendar_field_event'); ?></th>
			</tr>
		</thead>
		<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
					<tr>
						<td colspan='<?php echo $num_columns; ?>'>
							<?php echo lang('bf_with_selected'); ?>
							<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('calendar_delete_confirm'))); ?>')" />
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
							<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->db_date; ?>' /></td>
						<?php endif; ?>

						<?php if ($can_edit) : ?>
							<td><?php echo anchor(SITE_AREA . '/content/planning/edit_calendar/' . $record->db_date, '<span class="icon-pencil"></span> ' .  $record->db_date); ?></td>
						<?php else : ?>
							<td><?php e($record->db_date); ?></td>
						<?php endif; ?>
						<td><?php e($record->year); ?></td>
						<td><?php e($record->month); ?></td>
						<td><?php e($record->day); ?></td>
						<td><?php e($record->quarter); ?></td>
						<td><?php e($record->week); ?></td>
						<td><?php e($record->day_name); ?></td>
						<td><?php e($record->month_name); ?></td>
						<td><?php e($record->holiday_flag); ?></td>
						<td><?php e($record->weekend_flag); ?></td>
						<td><?php e($record->event); ?></td>
					</tr>
				<?php
				endforeach;
			else :
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('calendar_records_empty'); ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<?php
	echo form_close();

	echo $this->pagination->create_links();
	?>
</div>