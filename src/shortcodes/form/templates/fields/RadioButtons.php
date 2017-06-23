<?php
/** @var WiseFormsFieldProcessor $processor */
?>
<div class="<?php if ($labelLocation == 'inline' && strlen($labelWidth) > 0) { ?>wfTable<?php } ?>">
	<?php if (strlen($label) > 0) { ?>
		<label class="wfFieldLabel<?php if ($labelLocation == 'inline') { ?> wfCell<?php } ?> wfFieldLabelAlign<?php echo ucfirst($labelAlign); ?>"
			   style="<?php if (strlen($labelWidth) > 0) { ?>width: <?php echo $labelWidth; ?>px<?php } ?>"
		>
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>

	<span class="<?php if ($labelLocation == 'inline') { ?>wfCell<?php } ?>">
		<?php if (is_array($options)) { ?>
			<?php foreach ($options as $key => $option) { ?>
				<label class="wfRadioButtonsLabel"><input type="radio"
														id="<?php echo $id; ?>_<?php echo $key; ?>"
														name="<?php echo $id; ?>"
														class="wfRadioButtons"
														<?php echo $processor->getPostedValue($field) == $option['key'] ? 'checked' : ''; ?>
														value="<?php echo $this->safeText($option['key']); ?>"
					/><?php echo $option['value']; ?></label>
			<?php } ?>
		<?php } ?>
	</span>
</div>