<?php
	/** @var WiseFormsAdminFormsController $this */
	/** @var WiseFormsForm $form */
?>
<div id="postbox-container-2" class="postbox-container">

	<div class="postbox ">
		<div class="handlediv" title="Click to toggle"><br></div>
		<h3 class="hndle ui-sortable-handle"><span>Messages</span></h3>
		<div class="inside">
			<table class="links-table" cellpadding="0">
				<tbody>
					<?php foreach ($this->getFormMessages($form) as $message) { ?>
						<tr>
							<td>
								<input name="message.<?php echo $message['id']; ?>" type="text" value="<?php echo $this->safeText($message['value']); ?>" class="regular-text" required />

								<p class="description">
									"<?php echo $message['default']; ?>"
								</p>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

</div>

<br class="wfClear" />