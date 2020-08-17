<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('calendar_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($calendar->db_date) ? $calendar->db_date : '';

?>
<div class='admin-box'>
    <h3>Calendar</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('db_date') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_db_date'), 'db_date', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='db_date' type='text' name='db_date'  value="<?php echo set_value('db_date', isset($calendar->db_date) ? $calendar->db_date : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('db_date'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('year') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_year'), 'year', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='year' type='text' name='year' maxlength='11' value="<?php echo set_value('year', isset($calendar->year) ? $calendar->year : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('year'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('month') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_month'), 'month', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='month' type='text' name='month' maxlength='11' value="<?php echo set_value('month', isset($calendar->month) ? $calendar->month : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('month'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('day') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_day'), 'day', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='day' type='text' name='day' maxlength='11' value="<?php echo set_value('day', isset($calendar->day) ? $calendar->day : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('day'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('quarter') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_quarter'), 'quarter', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='quarter' type='text' name='quarter' maxlength='11' value="<?php echo set_value('quarter', isset($calendar->quarter) ? $calendar->quarter : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('quarter'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('week') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_week'), 'week', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='week' type='text' name='week' maxlength='11' value="<?php echo set_value('week', isset($calendar->week) ? $calendar->week : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('week'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('day_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_day_name'), 'day_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='day_name' type='text' name='day_name' maxlength='9' value="<?php echo set_value('day_name', isset($calendar->day_name) ? $calendar->day_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('day_name'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('month_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_month_name'), 'month_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='month_name' type='text' name='month_name' maxlength='9' value="<?php echo set_value('month_name', isset($calendar->month_name) ? $calendar->month_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('month_name'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('holiday_flag') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_holiday_flag'), 'holiday_flag', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='holiday_flag' type='text' name='holiday_flag' maxlength='1' value="<?php echo set_value('holiday_flag', isset($calendar->holiday_flag) ? $calendar->holiday_flag : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('holiday_flag'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('weekend_flag') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_weekend_flag'), 'weekend_flag', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='weekend_flag' type='text' name='weekend_flag' maxlength='1' value="<?php echo set_value('weekend_flag', isset($calendar->weekend_flag) ? $calendar->weekend_flag : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('weekend_flag'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('event') ? ' error' : ''; ?>">
                <?php echo form_label(lang('calendar_field_event'), 'event', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='event' type='text' name='event' maxlength='50' value="<?php echo set_value('event', isset($calendar->event) ? $calendar->event : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('event'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('calendar_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/planning/calendar', lang('calendar_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Planning.Content.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('calendar_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('calendar_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>