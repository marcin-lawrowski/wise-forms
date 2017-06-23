<?php
/** @var WiseFormsFieldProcessor $processor */
?>
<div class="<?php if ($labelLocation == 'inline' && strlen($labelWidth) > 0) { ?>wfTable<?php } ?>">
	<?php if (strlen($label) > 0) { ?>
		<label for="<?php echo $id; ?>"
			   class="wfFieldLabel<?php if ($labelLocation == 'inline') { ?> wfCell<?php } ?> wfFieldLabelAlign<?php echo ucfirst($labelAlign); ?>"
			   style="<?php if (strlen($labelWidth) > 0) { ?>width: <?php echo $labelWidth; ?>px<?php } ?>"
		>
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>

	<span class="<?php if ($labelLocation == 'inline') { ?>wfCell<?php } ?><?php if ($width == '100%') { ?> wfWidth100<?php } ?>">
		<textarea id="<?php echo $id; ?>"
				name="<?php echo $id; ?>"
				style="<?php if (strlen($height) > 0) { ?>height: <?php echo $height; ?>px<?php } ?>"
				placeholder="<?php echo $this->safeText($placeholder); ?>"
				class="wfTextArea<?php if ($width == '100%') { ?> wfWidth100<?php } ?>"
		><?php echo $this->safeText($processor->getPostedValue($field)); ?></textarea>
	</span>
</div>