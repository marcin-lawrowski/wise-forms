<div class="wrap wfAdminPage">
	<h2>Form: <?php echo $this->safeText($form->getId() > 0 ? $form->getName() : 'New Form'); ?></h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<form class="wfFormAddEdit" action="<?php echo $form->getId() > 0 ? $this->getObjectSaveUrl($form->getId()) : $this->getObjectAddUrl(); ?>" method="POST">

				<div id="postbox-container-1" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable" style="">
						<div id="submitdiv" class="postbox ">
							<h2 class="hndle ui-sortable-handle"><span>Form Details</span></h2>
							<div class="inside">
								<div class="submitbox" id="submitpost">
									<div id="minor-publishing">
										<div id="misc-publishing-actions">
											<div class="misc-pub-section misc-pub-post-status">
												Status:
												<span id="post-status-display">
													<?php if ($form->getId() > 0) { ?>
														Published
													<?php } else { ?>
														New
													<?php } ?>
												</span>
											</div>
											<?php if ($form->getId() > 0) { ?>
												<div class="misc-pub-section curtime misc-pub-curtime">
													<span id="timestamp">Created on: <b><?php echo date('Y-m-d H:i:s', $form->getCreated()); ?></b></span>
												</div>
												<div class="misc-pub-section">
													<span>Results: <b><?php echo $resultsCount; ?></b></span>
												</div>
												<div class="misc-pub-section">
													<span>Shortcode: <pre><code>[wise-forms id="<?php echo $form->getId(); ?>"]</code></pre></span>
												</div>
											<?php } ?>
										</div>
										<div class="clear"></div>
									</div>

									<div id="major-publishing-actions">
										<?php if ($form->getId() > 0) { ?>
											<div id="delete-action">
												<a class="submitdelete deletion" href="<?php echo $this->getObjectDeleteUrl($form->getId()); ?>" onclick="return confirm('Are you sure you want to delete the form?')">Delete</a>
											</div>
										<?php } ?>

										<div id="publishing-action">
											<input name="save" type="submit" class="button button-primary button-large" value="<?php echo $form->getId() > 0 ? 'Update' : 'Save'; ?>">
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="wfTabs tabs-style-flip">
					<nav>
						<ul>
							<li><a href="#wf-tab-base" class="icon icon-start"><span>Base</span></a></li>
							<li><a href="#wf-tab-fields" class="icon icon-fields"><span>Fields</span></a></li>
							<li><a href="#wf-tab-messages" class="icon icon-messages"><span>Messages</span></a></li>
							<li><a href="#wf-tab-target" class="icon icon-mail"><span>Target</span></a></li>
						</ul>
					</nav>
					<div class="wfTabsContentWrap">
						<section id="wf-tab-base-section">
							<?php include('FormAddEdit-HomeTab.php'); ?>
						</section>
						<section id="wf-tab-fields-section">
							<?php include('FormAddEdit-FieldsTab.php'); ?>
						</section>
						<section id="wf-tab-messages-section">
							<?php include('FormAddEdit-MessagesTab.php'); ?>
						</section>
						<section id="wf-tab-target-section">
							<?php include('FormAddEdit-TargetsTab.php'); ?>
						</section>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>