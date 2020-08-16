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
            <?php echo form_label(lang('models_field_desc'), 'desc', array('class' => 'control-label')); ?>
            <div class='controls'>
                <input id='desc' type='text' name='desc' maxlength='255' value="<?php echo set_value('desc', isset($models->desc) ? $models->desc : ''); ?>" />
                <span class='help-inline'><?php echo form_error('desc'); ?></span>
            </div>
        </div>
        <div class="control-group<?php echo form_error('deleted') ? ' error' : ''; ?>">
            <?php echo form_label(lang('models_field_deleted'), 'deleted', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php // FIXME: not able to get checkbox value undelete 
                ?>
                <input id='deleted' type='checkbox' name='deleted' maxlength='1' value="<?php echo set_value('deleted', isset($models->deleted) ? $models->deleted : ''); ?>" <?php echo $models->deleted == 1 ? 'checked' : '' ?> />
                <span class='help-inline'><?php echo form_error('deleted'); ?></span>
            </div>
        </div>
    </fieldset>
    <fieldset class='form-actions'>
        <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('models_action_edit'); ?>" />
        <?php echo lang('bf_or'); ?>
        <?php echo anchor(SITE_AREA . '/content/sales/models', lang('models_cancel'), 'class="btn btn-warning"'); ?>

        <?php if ($this->auth->has_permission('Sales.Content.Delete')) : ?>
            <?php echo lang('bf_or'); ?>
            <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('models_delete_confirm'))); ?>');">
                <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('models_delete_record'); ?>
            </button>
        <?php endif; ?>
    </fieldset>
    <?php echo form_close(); ?>
</div>