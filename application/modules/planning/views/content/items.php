<?php

$num_columns    = 7;
$can_delete    = $this->auth->has_permission('Planning.Content.Delete');
$can_edit        = $this->auth->has_permission('Planning.Content.Edit');
$has_records    = isset($records) && is_array($records) && count($records);

?>
<div class='admin-box'>
    <h3>
        <?php echo lang('items_area_title'); ?>
    </h3>
    <?php echo form_open($this->uri->uri_string()); ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th><?php echo lang('items_field_item_id'); ?></th>
                <th><?php echo lang('items_field_desc'); ?></th>
                <th><?php echo lang('items_field_item_type'); ?></th>
                <th><?php echo lang('items_field_search_key'); ?></th>
                <th><?php echo lang('items_field_item_group'); ?></th>
                <th><?php echo lang('items_field_item_group_desc'); ?></th>
                <th><?php echo lang('items_field_unit'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($has_records) :
                foreach ($records as $record) :
            ?>
                    <tr>
                        <?php if ($can_edit) : ?>
                            <td><?php echo anchor(SITE_AREA . '/content/planning/bom/' . $record['id'], '<span class="icon-list"></span> ' .  $record['id']); ?></td>
                        <?php else : ?>
                            <td><?php $record['id']; ?></td>
                        <?php endif; ?>
                        <td><?php echo $record['description']; ?></td>
                        <td><?php echo $record['item_type']; ?></td>
                        <td><?php echo $record['search_key']; ?></td>
                        <td><?php echo $record['item_group']; ?></td>
                        <td><?php echo $record['item_group_desc']; ?></td>
                        <td><?php echo $record['unit']; ?></td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan='<?php echo $num_columns; ?>'><?php echo lang('items_records_empty'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
    echo form_close();

    echo $this->pagination->create_links();
    ?>
</div>