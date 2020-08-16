<?php

$num_columns    = 19;
$can_delete    = $this->auth->has_permission('Sales.Content.Delete');
$can_edit        = $this->auth->has_permission('Sales.Content.Edit');
$has_records    = isset($records) && is_array($records) && count($records);

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
                <th><?php echo lang('forecast_field_fy'); ?></th>
                <th><?php echo lang('forecast_field_p_one'); ?></th>
                <th><?php echo lang('forecast_field_p_two'); ?></th>
                <th><?php echo lang('forecast_field_p_three'); ?></th>
                <th><?php echo lang('forecast_field_p_four'); ?></th>
                <th><?php echo lang('forecast_field_p_five'); ?></th>
                <th><?php echo lang('forecast_field_p_six'); ?></th>
                <th><?php echo lang('forecast_field_p_seven'); ?></th>
                <th><?php echo lang('forecast_field_p_eight'); ?></th>
                <th><?php echo lang('forecast_field_p_nine'); ?></th>
                <th><?php echo lang('forecast_field_p_ten'); ?></th>
                <th><?php echo lang('forecast_field_p_eleven'); ?></th>
                <th><?php echo lang('forecast_field_p_twelve'); ?></th>
                <th><?php echo lang('forecast_column_deleted'); ?></th>
                <th><?php echo lang('forecast_column_created'); ?></th>
                <th><?php echo lang('forecast_column_modified'); ?></th>
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
                        <td><?php e($record->fy); ?></td>
                        <td><?php e($record->p_one); ?></td>
                        <td><?php e($record->p_two); ?></td>
                        <td><?php e($record->p_three); ?></td>
                        <td><?php e($record->p_four); ?></td>
                        <td><?php e($record->p_five); ?></td>
                        <td><?php e($record->p_six); ?></td>
                        <td><?php e($record->p_seven); ?></td>
                        <td><?php e($record->p_eight); ?></td>
                        <td><?php e($record->p_nine); ?></td>
                        <td><?php e($record->p_ten); ?></td>
                        <td><?php e($record->p_eleven); ?></td>
                        <td><?php e($record->p_twelve); ?></td>
                        <td><?php echo $record->deleted > 0 ? lang('forecast_true') : lang('forecast_false'); ?></td>
                        <td><?php e($record->created_on); ?></td>
                        <td><?php e($record->modified_on); ?></td>
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