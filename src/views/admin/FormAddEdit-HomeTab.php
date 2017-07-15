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
					<tr>
						<th scope="row">
							<label>Display Name:</label>
						</th>
						<td>
							<label>
								<input name="appearance.header" type="radio" value="1" <?php echo $form->getConfigurationEntry('appearance.header') == '1' ? 'checked' : ''; ?> />
								Yes
							</label>
							<label>
								<input name="appearance.header" type="radio" value="0" <?php echo $form->getConfigurationEntry('appearance.header') == '0' ? 'checked' : ''; ?> />
								No
							</label>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>

<br class="wfClear" />