<div class="wrap kaine-shop">
	<h2>Form: <?php echo $this->safeText($form->getId() > 0 ? $form->getName() : 'New Form'); ?></h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="postbox-container-2" class="postbox-container">

				<div class="postbox ">
					<div class="handlediv" title="Click to toggle"><br></div>
					<h3 class="hndle ui-sortable-handle"><span>Base details</span></h3>
					<div class="inside">
						<form action="<?php echo $form->getId() > 0 ? $this->getObjectSaveUrl($form->getId()) : $this->getObjectAddUrl(); ?>" method="POST">
							<table class="links-table" cellpadding="0">
								<tbody>
								<?php if ($form->getId() > 0) { ?>
									<tr>
										<th scope="row">
											<label>ID</label>
										</th>
										<td>
											<?php echo $form->getId(); ?>
										</td>
									</tr>
								<?php } ?>
								<tr>
									<th scope="row">
										<label for="name">Name</label>
									</th>
									<td>
										<input name="name" type="text" id="name" value="<?php echo $this->safeText($form->getName()); ?>" class="regular-text" required />
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="submit" class="button button-primary button-large" value="Save" />
									</td>
								</tr>
								</tbody>
							</table>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>

</div>