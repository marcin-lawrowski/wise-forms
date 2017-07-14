<?php
/** @var WiseFormsFieldProcessor $processor */
?>
<div class="<?php echo $containerClasses; ?>">
	<?php if (strlen($label) > 0 && $labelLocation != 'bottom') { ?>
		<label for="<?php echo $id; ?>" class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>

	<span class="<?php echo $inputContainerClasses; ?>">
		<textarea id="<?php echo $id; ?>"
				name="<?php echo $id; ?>"
				style="<?php echo $inputStyles; ?>"
				placeholder="<?php echo $this->safeText($placeholder); ?>"
				class="<?php echo $inputClasses; ?>"
		><?php echo $this->safeText($processor->getPostedValue($field)); ?></textarea>
	</span>

	<?php if (strlen($label) > 0 && $labelLocation == 'bottom') { ?>
		<label for="<?php echo $id; ?>" class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>
</div>