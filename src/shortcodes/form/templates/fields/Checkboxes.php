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
	<?php
		$postedValues = array_keys($processor->getPostedValue($field));
	?>
	<span class="<?php if ($labelLocation == 'inline') { ?>wfCell<?php } ?><?php echo strlen($layout) > 0 ? ' wfFieldLayout'.$layout : ''; ?>">
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
</div>