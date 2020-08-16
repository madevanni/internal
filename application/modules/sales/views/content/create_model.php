<?php
if (validation_errors()) :
?>
    <div class='alert alert-block alert-error fade in'>
        <a class='close' data-dismiss='alert'>&times;</a>
        <h4 class='alert-heading'>
            <?php echo lang('models_errors_message'); ?>
        </h4>
        <?php echo validation_errors(); ?>
    </div>
<?php
endif;

$id = isset($models->id) ? $models->id : '';

?>
<div class='admin-box'>
    <h3>Models</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group<?php echo form_error('desc') ? ' error' : ''; ?>">
            <?php echo form_label(lang('models_field_desc') . lang('bf_form_label_required'), 'desc', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='desc' type='text' required='required' name='desc' maxlength='255' value="<?php echo set_value('desc', isset($models->desc) ? $models->desc : ''); ?>" />
                <span class='help-inline'><?php echo form_error('desc'); ?></span>
            </div>
        </div>
    </fieldset>
    <fieldset class='form-actions'>
        <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('models_action_create'); ?>" />
        <?php echo lang('bf_or'); ?>
        <?php echo anchor(SITE_AREA . '/content/sales/models', lang('models_cancel'), 'class="btn btn-warning"'); ?>
    </fieldset>
    <?php echo form_close(); ?>
</div>