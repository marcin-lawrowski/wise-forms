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
		<input id="<?php echo $id; ?>"
			   name="<?php echo $id; ?>"
			   type="text"
			   placeholder="<?php echo htmlentities($placeholder, ENT_QUOTES, 'UTF-8'); ?>"
			   class="wfFieldInput<?php if ($width == '100%') { ?> wfWidth100<?php } ?>"
		/>
	</span>
</div>