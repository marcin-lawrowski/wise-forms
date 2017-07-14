<?php
/** @var WiseFormsFieldProcessor $processor */
?>
<div class="<?php echo $containerClasses; ?>">
	<?php if (strlen($label) > 0 && $labelLocation != 'bottom') { ?>
		<label class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>
	<?php
		$postedValues = array_keys($processor->getPostedValue($field));
	?>
	<span class="<?php echo $inputContainerClasses; ?>">
		<?php if (is_array($options)) { ?>
			<?php foreach ($options as $key => $option) { ?>
				<label class="wfCheckboxesLabel"><input type="checkbox"
						   id="<?php echo $id; ?>_<?php echo $key; ?>"
						   name="<?php echo $id; ?>[]"
						   class="wfCheckboxes"
						   <?php echo in_array($option['key'], $postedValues) ? 'checked' : ''; ?>
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