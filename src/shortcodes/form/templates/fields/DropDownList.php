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
		<select id="<?php echo $id; ?>"
			   name="<?php echo $id; ?>"
			   class="wfDropDownList<?php if ($width == '100%') { ?> wfWidth100<?php } ?>"
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
</div>