<?php if (has_permission('Sales.Content.View')) : ?>
	<ul class="nav nav-pills">
		<li <?php echo $this->uri->segment(4) == 'partners' ? 'class="active"' : '' ?>>
			<a href="<?php echo site_url(SITE_AREA . '/content/sales/partners') ?>" id="bom">Business Partners</a>
		</li>
		<li <?php echo $this->uri->segment(4) == 'forecast' ? 'class="active"' : '' ?>>
			<a href="<?php echo site_url(SITE_AREA . '/content/sales/forecast') ?>" id="forecast">Forecast</a>
		</li>
		<li <?php echo $this->uri->segment(4) == 'models' ? 'class="active"' : '' ?>>
			<a href="<?php echo site_url(SITE_AREA . '/content/sales/models') ?>" id="models">Models</a>
		</li>
	</ul>
<?php endif; ?>