<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/planning';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == 'calendar' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl. '/calendar'); ?>" id='list'>
            <?php echo lang('calendar_list'); ?>
        </a>
	</li>
	<?php if ($this->auth->has_permission('Planning.Content.Create')) : ?>
	<li<?php echo $checkSegment == 'create_calendar' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl . '/create_calendar'); ?>" id='create_new'>
            <?php echo lang('calendar_new'); ?>
        </a>
	</li>
	<?php endif; ?>
</ul>