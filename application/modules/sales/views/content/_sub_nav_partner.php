<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/planning';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == 'partners' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl . 'partners'); ?>" id='list'>
			<?php echo lang('partners_list'); ?>
		</a>
		</li>
</ul>