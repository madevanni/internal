<?php if (has_permission('Planning.Content.View')):?>
<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == 'bom' ? 'class="active"' : '' ?>>
            <a href="<?php echo site_url(SITE_AREA .'/content/planning/bom') ?>" id="bom">Bill of Materials</a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'forecast' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/planning/forecast') ?>" id="forecast">Forecast</a>
	</li>
        <li <?php echo $this->uri->segment(4) == 'items' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/planning/items') ?>" id="items">Items</a>
	</li>
</ul>
<?php endif;?>