<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/sales';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == 'forecast' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl. '/forecast'); ?>" id='list'>
            <?php echo lang('forecast_list'); ?>
        </a>
	</li>
	<?php if ($this->auth->has_permission('Sales.Content.Create')) : ?>
	<li<?php echo $checkSegment == 'create_forecast' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl . '/create_forecast'); ?>" id='create_new'>
            <?php echo lang('forecast_new'); ?>
        </a>
	</li>
	<?php endif; ?>
</ul>