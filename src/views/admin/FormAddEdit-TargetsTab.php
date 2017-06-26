<?php
	/** @var WiseFormsAdminFormsController $this */
	/** @var WiseFormsForm $form */
?>
<div id="postbox-container-2" class="postbox-container">

	<div class="postbox ">
		<div class="handlediv" title="Click to toggle"><br></div>
		<h3 class="hndle ui-sortable-handle"><span>E-mail Notification</span></h3>
		<div class="inside">
			<table class="links-table" cellpadding="0">
				<tbody>
					<tr>
						<th scope="row">
							<label for="notification.email.recipient">Recipient E-mail</label>
						</th>
						<td>
							<input name="notifications.email.recipient" type="email" id="notification.email.recipient"
								   value="<?php echo $this->safeText($form->getConfigurationEntry('notifications.email.recipient')); ?>" class="regular-text" />
							<p class="description">E-mail address that is notified after the form is sent</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="notification.email.recipient.name">Recipient Name</label>
						</th>
						<td>
							<input name="notifications.email.recipient.name" type="text" id="notification.email.recipient.name"
								   value="<?php echo $this->safeText($form->getConfigurationEntry('notifications.email.recipient.name')); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="notification.email.subject">E-mail Subject</label>
						</th>
						<td>
							<input name="notifications.email.subject" type="text" id="notification.email.subject"
								   value="<?php echo $this->safeText($form->getConfigurationEntry('notifications.email.subject')); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="notification.email.template">E-mail Template</label>
						</th>
						<td>
							<textarea id="notifications.email.template" rows="10" name="notifications.email.template"><?php echo $this->safeText($form->getConfigurationEntry('notifications.email.template')); ?></textarea>
							<p class="description">
								You can use the following dynamic template parts:
								<ul>
									<li><strong>${fields}</strong> - displays all submitted fields</li>
									<li><strong>${ip}</strong> - displays IP address of the host that submitted the form</li>
								</ul>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>

<br class="wfClear" />