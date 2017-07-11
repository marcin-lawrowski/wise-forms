<?php
/** @var WiseFormsFieldProcessor $processor */
?>
<div class="<?php if ($labelLocation == 'inline' && strlen($labelWidth) > 0) { ?>wfTable<?php } ?>">
	<?php if (strlen($label) > 0 && $labelLocation != 'bottom') { ?>
		<label for="<?php echo $id; ?>"
			   class="wfFieldLabel<?php if ($labelLocation == 'inline') { ?> wfCell<?php } ?> wfFieldLabelAlign<?php echo ucfirst($labelAlign); ?>"
			   style="<?php if (strlen($labelWidth) > 0) { ?>width: <?php echo $labelWidth; ?>px<?php } ?>"
		>
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>

	<?php
		$firstArgument = rand(1, 9);
		$secondArgument = rand(1, 9);
		$action = rand(0, 1);
		$result = null;
		$operator = '';
		if ($action === 0) {
			$result = $firstArgument + $secondArgument;
			$operator = ' + ';
		}
		if ($action === 1) {
			$result = $firstArgument - $secondArgument;
			$operator = ' - ';
		}

		$result = base64_encode(WiseFormsCrypt::encrypt($result));
	?>

	<span class="<?php if ($labelLocation == 'inline') { ?>wfCell<?php } ?>">

			<span class="wfFieldSimpleCaptchaCalculation"><?php echo $firstArgument; ?><?php echo $operator; ?><?php echo $secondArgument; ?> =</span>
			<input id="<?php echo $id; ?>"
				   name="<?php echo $id; ?>"
				   type="text"
				   value=""
				   class="wfFieldInput"
			/>

		<input type="hidden" name="<?php echo $id; ?>_result" value="<?php echo $result; ?>" />
	</span>

	<?php if (strlen($label) > 0 && $labelLocation == 'bottom') { ?>
		<label for="<?php echo $id; ?>"
			   class="wfFieldLabel wfFieldLabelAlign<?php echo ucfirst($labelAlign); ?>"
			   style="<?php if (strlen($labelWidth) > 0) { ?>width: <?php echo $labelWidth; ?>px<?php } ?>"
		>
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>
</div>