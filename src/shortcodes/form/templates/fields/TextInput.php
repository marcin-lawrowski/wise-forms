<?php
/** @var WiseFormsFieldProcessor $processor */
/** @var array $field */
/** @var string $containerClasses */
/** @var string $labelLocation */
/** @var string $labelClasses */
/** @var string $labelStyles */
/** @var boolean $required */
/** @var string $inputContainerClasses */
/** @var string $inputClasses */
/** @var string $placeholder */
?>
<div class="<?php echo $containerClasses; ?>">
	<?php if (strlen($label) > 0 && $labelLocation != 'bottom') { ?>
		<label for="<?php echo $id; ?>" class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>

	<span class="<?php echo $inputContainerClasses; ?>">
		<input id="<?php echo $id; ?>"
			   name="<?php echo $id; ?>"
			   type="text"
			   value="<?php echo $this->safeText($processor->getPostedValue($field)); ?>"
			   placeholder="<?php echo $this->safeText($placeholder); ?>"
			   class="<?php echo $inputClasses; ?>"
		/>
	</span>

	<?php if (strlen($label) > 0 && $labelLocation == 'bottom') { ?>
		<label for="<?php echo $id; ?>" class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>
</div>