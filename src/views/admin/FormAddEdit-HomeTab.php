<div id="postbox-container-2" class="postbox-container">

	<div class="postbox ">
		<div class="handlediv" title="Click to toggle"><br></div>
		<h3 class="hndle ui-sortable-handle"><span>Base details</span></h3>
		<div class="inside">
			<table class="links-table" cellpadding="0">
				<tbody>
					<tr>
						<th scope="row">
							<label for="name">Name:</label>
						</th>
						<td>
							<input name="name" type="text" id="name" value="<?php echo $this->safeText($form->getName()); ?>" class="regular-text" required />
						</td>
					</tr>
					<?php if ($form !== null) { ?>
						<tr>
							<th scope="row">
								<label for="name">Shortcode:</label>
							</th>
							<td>
								<pre><code>[wise-forms id="<?php echo $form->getId(); ?>"]</code></pre>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

</div>

<br class="wfClear" />