<div class="wrap wfAdminPage">
	<h2>Form Wizard</h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<form class="wfFormAddEdit" action="<?php echo $this->getWizardAddUrl(); ?>" method="POST">

				<div class="postbox ">
					<div class="inside">
						<?php if ($form === null) { ?>
							<p class="description" style="font-size: 1.2em;">
								You can quickly create sample forms and improve them later.
							</p>
							<br />
							<label for="name">1. Form Name:</label>
							<br />
							<input type="text" required id="name" name="name" value="Default Form" style="width: 250px" />
							<br />
							<br />
							2. Form Template:<br />
							<label><input type="radio" name="type" value="contact" checked /> Contact Form</label>
							<label><input type="radio" name="type" value="application" /> Application Form</label>
							<p class="description">
								Each template has a different set of fields that can be adjusted later.
							</p>
							<br />
							<label for="email">3. Administrator E-mail:</label>
							<br />
							<input type="email" required id="email" name="email" style="width: 250px" />
							<p class="description">
								Form administrator will be notified on this e-mail after every submission.
							</p>
							<br />
							<hr />
							<input name="save" type="submit" class="button button-primary button-large" value="Create Form">
						<?php } else { ?>
							<p class="description" style="font-size: 1.2em;">
								Congratulations! It's done!
							</p>
							<br />
							<p class="description">
								You can display the form by inserting the following shortcode in your post or a page:
							</p>

							<pre><code>[wise-forms id="<?php echo $form->getId(); ?>"]</code></pre>
							<br />
							<p class="description">
								You can also adjust the form first:
							</p>
							<input type="button" class="button button-primary button-large" value="Edit Form" onclick="window.location = '<?php echo $this->getEditUrl($form->getId()); ?>';" />
						<?php } ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>