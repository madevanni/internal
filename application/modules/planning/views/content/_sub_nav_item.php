<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/planning';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == 'items' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl. '/items'); ?>" id='list'>
            <?php echo lang('items_list'); ?>
        </a>
	</li>
</ul>