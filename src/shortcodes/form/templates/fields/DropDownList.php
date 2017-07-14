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
		<select id="<?php echo $id; ?>"
			   name="<?php echo $id; ?>"
			   class="<?php echo $inputClasses; ?>"
		>
			<?php if (strlen($placeholder) > 0) { ?>
				<option disabled selected><?php echo $this->safeText($placeholder); ?></option>
			<?php } ?>
			<?php if (is_array($options)) { ?>
				<?php foreach ($options as $option) { ?>
					<option value="<?php echo $this->safeText($option['key']); ?>" <?php echo $processor->getPostedValue($field) == $option['key'] ? 'selected' : ''; ?>>
						<?php echo $this->safeText($option['value']); ?>
					</option>
				<?php } ?>
			<?php } ?>
		</select>
	</span>

	<?php if (strlen($label) > 0 && $labelLocation == 'bottom') { ?>
		<label for="<?php echo $id; ?>" class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>
</div>