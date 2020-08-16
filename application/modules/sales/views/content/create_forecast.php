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
            <?php echo form_label(lang('forecast_field_bp_id') . lang('bf_form_label_required'), 'bp_id', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='bp_id' type='text' required='required' name='bp_id' maxlength='255' value="<?php echo set_value('bp_id', isset($forecast->bp_id) ? $forecast->bp_id : ''); ?>" />
                <span class='help-inline'><?php echo form_error('bp_id'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('model_id') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_model_id') . lang('bf_form_label_required'), 'model_id', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='model_id' type='text' required='required' name='model_id' maxlength='11' value="<?php echo set_value('model_id', isset($forecast->model_id) ? $forecast->model_id : ''); ?>" />
                <span class='help-inline'><?php echo form_error('model_id'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('item_id') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_item_id') . lang('bf_form_label_required'), 'item_id', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='item_id' type='text' required='required' name='item_id' maxlength='255' value="<?php echo set_value('item_id', isset($forecast->item_id) ? $forecast->item_id : ''); ?>" />
                <span class='help-inline'><?php echo form_error('item_id'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('fy') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_fy') . lang('bf_form_label_required'), 'fy', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='fy' type='text' required='required' name='fy' maxlength='255' value="<?php echo set_value('fy', isset($forecast->fy) ? $forecast->fy : ''); ?>" />
                <span class='help-inline'><?php echo form_error('fy'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_one') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_one'), 'p_one', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_one' type='text' name='p_one' maxlength='11' placeholder="0" value="<?php echo set_value('p_one', isset($forecast->p_one) ? $forecast->p_one : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_one'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_two') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_two'), 'p_two', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_two' type='text' name='p_two' maxlength='11' placeholder="0" value="<?php echo set_value('p_two', isset($forecast->p_two) ? $forecast->p_two : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_two'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_three') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_three'), 'p_three', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_three' type='text' name='p_three' maxlength='11' placeholder="0" value="<?php echo set_value('p_three', isset($forecast->p_three) ? $forecast->p_three : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_three'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_four') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_four'), 'p_four', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_four' type='text' name='p_four' maxlength='11' placeholder="0" value="<?php echo set_value('p_four', isset($forecast->p_four) ? $forecast->p_four : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_four'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_five') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_five'), 'p_five', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_five' type='text' name='p_five' maxlength='11' placeholder="0" value="<?php echo set_value('p_five', isset($forecast->p_five) ? $forecast->p_five : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_five'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_six') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_six'), 'p_six', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_six' type='text' name='p_six' maxlength='11' placeholder="0" value="<?php echo set_value('p_six', isset($forecast->p_six) ? $forecast->p_six : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_six'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_seven') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_seven'), 'p_seven', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_seven' type='text' name='p_seven' maxlength='11' placeholder="0" value="<?php echo set_value('p_seven', isset($forecast->p_seven) ? $forecast->p_seven : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_seven'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_eight') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_eight'), 'p_eight', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_eight' type='text' name='p_eight' maxlength='11' placeholder="0" value="<?php echo set_value('p_eight', isset($forecast->p_eight) ? $forecast->p_eight : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_eight'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_nine') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_nine'), 'p_nine', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_nine' type='text' name='p_nine' maxlength='11' placeholder="0" value="<?php echo set_value('p_nine', isset($forecast->p_nine) ? $forecast->p_nine : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_nine'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_ten') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_ten'), 'p_ten', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_ten' type='text' name='p_ten' maxlength='11' placeholder="0" value="<?php echo set_value('p_ten', isset($forecast->p_ten) ? $forecast->p_ten : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_ten'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_eleven') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_eleven'), 'p_eleven', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_eleven' type='text' name='p_eleven' maxlength='11' placeholder="0" value="<?php echo set_value('p_eleven', isset($forecast->p_eleven) ? $forecast->p_eleven : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_eleven'); ?></span>
            </div>
        </div>

        <div class="control-group<?php echo form_error('p_twelve') ? ' error' : ''; ?>">
            <?php echo form_label(lang('forecast_field_p_twelve'), 'p_twelve', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='p_twelve' type='text' name='p_twelve' maxlength='11' placeholder="0" value="<?php echo set_value('p_twelve', isset($forecast->p_twelve) ? $forecast->p_twelve : ''); ?>" />
                <span class='help-inline'><?php echo form_error('p_twelve'); ?></span>
            </div>
        </div>
    </fieldset>
    <fieldset class='form-actions'>
        <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('forecast_action_create'); ?>" />
        <?php echo lang('bf_or'); ?>
        <?php echo anchor(SITE_AREA . '/content/sales/forecast', lang('forecast_cancel'), 'class="btn btn-warning"'); ?>

    </fieldset>
    <?php echo form_close(); ?>
</div>