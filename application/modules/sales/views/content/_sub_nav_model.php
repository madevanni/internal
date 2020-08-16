<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/sales';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == 'models' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl. '/models'); ?>" id='list'>
            <?php echo lang('models_list'); ?>
        </a>
	</li>
	<?php if ($this->auth->has_permission('Sales.Content.Create')) : ?>
	<li<?php echo $checkSegment == 'create_model' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl . '/create_model'); ?>" id='create_new'>
            <?php echo lang('models_new'); ?>
        </a>
	</li>
	<?php endif; ?>
</ul>