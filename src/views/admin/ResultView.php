<?php
	/** @var WiseFormsAdminResultsController $this */
	/** @var WiseFormsResult $result */
	/** @var array $flatFields */
?>
<div class="wrap wfAdminPage">
	<h2>Form Result: <?php echo $this->safeText($result->getId() > 0 ? $result->getFormName() : 'New Form'); ?></h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable" style="">
					<div id="submitdiv" class="postbox ">
						<h2 class="hndle ui-sortable-handle"><span>Form Result</span></h2>
						<div class="inside">
							<div class="submitbox" id="submitpost">
								<div id="minor-publishing">
									<div id="misc-publishing-actions">
										<div class="misc-pub-section curtime misc-pub-curtime">
											<span id="timestamp">Submitted on: <br /><b><?php echo date('Y-m-d H:i:s', $result->getCreated()); ?></b></span>
										</div>
										<div class="misc-pub-section curtime misc-pub-curtime">
											IP: <br /><b><?php echo $result->getIp(); ?></b></span>
										</div>
									</div>
									<div class="clear"></div>
								</div>

								<div id="major-publishing-actions">
									<div id="delete-action">
										<a class="submitdelete deletion" href="<?php echo $this->getObjectDeleteUrl($result->getId()); ?>" onclick="return confirm('Are you sure you want to delete the result?')">Delete</a>
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="postbox-container-2" class="postbox-container">
				<div class="postbox ">
					<div class="handlediv" title="Click to toggle"><br></div>
					<h3 class="hndle ui-sortable-handle"><span>Form results</span></h3>
					<div class="inside">
						<table class="links-table" cellpadding="0">
							<tbody>
								<?php $resultArray = json_decode($result->getResult(), true); ?>
								<?php $resultArray = is_array($resultArray) ? $resultArray : array(); ?>

								<?php foreach ($resultArray as $fieldResult) { ?>
									<?php $processor = $this->getFieldProcessor($fieldResult); ?>

									<tr>
										<th scope="row">
											<?php echo $this->getFieldResultName($fieldResult, $flatFields); ?>
										</th>
										<td>
											<?php echo $processor->getValueFromFieldResult($fieldResult); ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

			</div>

			<br class="wfClear" />
		</div>
	</div>
</div>