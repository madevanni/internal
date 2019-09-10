<div class="jumbotron" text-align="center">
	<h1>Welcome to PT. Sanden Indonesia</h1>

        <p class="lead"><b><i>"Let us develop with wisdom and prosper in harmony"</i></b> means that we should use our intelligence in combining our developmental and pioneering abilities to win prosperity for us all."</p>

	<?php if (isset($current_user->email)) : ?>
		<a href="<?php echo site_url(SITE_AREA) ?>" class="btn btn-large btn-success">Go to the Admin area</a>
	<?php else :?>
		<a href="<?php echo site_url(LOGIN_URL); ?>" class="btn btn-large btn-primary"><?php echo lang('bf_action_login'); ?></a>
	<?php endif;?>

	<!--<br/><br/><a href="<?php echo site_url('/docs') ?>" class="btn btn-large btn-info">Browse the Docs</a>-->
</div>

<hr />

<div class="row-fluid">

	<div class="span6">
		<h4>Our Management Principles</h4>

		<p>Have been the cornerstone of our employee's activities since the company's founding.</p>
	</div>

<!--	<div class="span6">
		<h4>A Growing Community</h4>

		<p>Bonfire has an ever-growing <a href="http://forums.cibonfire.com">community</a> of users that are there to help you get unstuck, or make the best use of this powerful system.</p>

		<p>Bugs and feature discussion also happen on GitHub's <a href="https://github.com/ci-bonfire/Bonfire/issues?direction=desc&labels=0.7&sort=created&state=open">issue tracker</a>. This is the best place to report bugs and discuss new features.</p>
	</div>-->
</div>

<!--<div class="row-fluid">

	<div class="span6">
		<h4>Built-in Flexibility</h4>

		<p>A <a href="https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc">modular system</a> that allows code re-use, and overriding core modules with custom modules.</p>

		<p>A <i>template system</i> that allows parent-child themes, and overriding controller views in the template.</p>

		<p><i>Role-Based Access Control</i> that provides as much fine-grained control as your modules need.</p>
	</div>

</div>-->