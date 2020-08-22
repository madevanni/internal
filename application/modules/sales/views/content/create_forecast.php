<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('forecast_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($forecast->id) ? $forecast->id : '';

?>
<div class='admin-box'>
    <h3>Forecast</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('bp_id') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forecast_field_bp_id'), 'bp_id', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='bp_id' type='text' name='bp_id' maxlength='255' value="<?php echo set_value('bp_id', isset($forecast->bp_id) ? $forecast->bp_id : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('bp_id'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('model_id') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forecast_field_model_id'), 'model_id', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='model_id' type='text' name='model_id' maxlength='11' value="<?php echo set_value('model_id', isset($forecast->model_id) ? $forecast->model_id : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('model_id'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('item_id') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forecast_field_item_id'), 'item_id', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='item_id' type='text' name='item_id' maxlength='255' value="<?php echo set_value('item_id', isset($forecast->item_id) ? $forecast->item_id : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('item_id'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('cust_part') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forecast_field_cust_part'), 'cust_part', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='cust_part' type='text' name='cust_part' maxlength='255' value="<?php echo set_value('cust_part', isset($forecast->cust_part) ? $forecast->cust_part : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('cust_part'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('fy') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forecast_field_fy'), 'fy', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='fy' type='text' name='fy' maxlength='4' value="<?php echo set_value('fy', isset($forecast->fy) ? $forecast->fy : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('fy'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('period') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forecast_field_period'), 'period', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='period' type='text' name='period' maxlength='2' value="<?php echo set_value('period', isset($forecast->period) ? $forecast->period : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('period'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('sales_qty') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forecast_field_sales_qty'), 'sales_qty', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='sales_qty' type='text' name='sales_qty' maxlength='11' value="<?php echo set_value('sales_qty', isset($forecast->sales_qty) ? $forecast->sales_qty : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('sales_qty'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('forecast_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/forecast', lang('forecast_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>