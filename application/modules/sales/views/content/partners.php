<?php

$num_columns    = 9;
$can_delete    = $this->auth->has_permission('Sales.Content.Delete');
$can_edit        = $this->auth->has_permission('Sales.Content.Edit');
$has_records    = isset($records) && is_array($records) && count($records);

?>
<div class='admin-box'>
    <h3>
        <?php echo lang('partners_area_title'); ?>
    </h3>
    <?php echo form_open($this->uri->uri_string()); ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th><?php echo lang('partners_field_partners'); ?></th>
                <th><?php echo lang('partners_field_address'); ?></th>
                <th><?php echo lang('partners_field_zipcode'); ?></th>
                <th><?php echo lang('partners_field_city'); ?></th>
                <th><?php echo lang('partners_field_country'); ?></th>
                <th><?php echo lang('partners_field_telephone'); ?></th>
                <th><?php echo lang('partners_field_currency'); ?></th>
                <th><?php echo lang('partners_field_role'); ?></th>
                <th><?php echo lang('partners_field_status'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($has_records) :
                foreach ($records as $record) :
            ?>
                    <tr>
                        <?php if ($can_edit) : ?>
                            <td><?php echo anchor(SITE_AREA . '/content/sales/partners_details/' . $record['id'], '<span class="icon-user"></span> ' .  $record['partners']); ?></td>
                        <?php else : ?>
                            <td><?php echo $record['partners']; ?></td>
                        <?php endif; ?>
                        <td><?php echo $record['address']; ?></td>
                        <td><?php echo $record['zipcode']; ?></td>
                        <td><?php echo $record['city']; ?></td>
                        <td><?php echo $record['country']; ?></td>
                        <td><?php echo $record['telephone']; ?></td>
                        <td><?php echo $record['currency']; ?></td>
                        <td><?php echo $record['role']; ?></td>
                        <td><?php echo $record['status']; ?></td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan='<?php echo $num_columns; ?>'><?php echo lang('partners_records_empty'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
    echo form_close();

    echo $this->pagination->create_links();
    ?>
</div>