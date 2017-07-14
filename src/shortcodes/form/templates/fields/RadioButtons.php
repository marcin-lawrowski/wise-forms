<?php
/** @var WiseFormsFieldProcessor $processor */
?>
<div class="<?php echo $containerClasses; ?>">
	<?php if (strlen($label) > 0 && $labelLocation != 'bottom') { ?>
		<label class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>

	<span class="<?php echo $inputContainerClasses; ?>">
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

	<?php if (strlen($label) > 0 && $labelLocation == 'bottom') { ?>
		<label class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>
</div>