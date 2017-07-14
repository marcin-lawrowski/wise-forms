<?php
/** @var WiseFormsFieldProcessor $processor */
?>
<div class="<?php echo $containerClasses; ?>"">
	<?php if (strlen($label) > 0 && $labelLocation != 'bottom') { ?>
		<label for="<?php echo $id; ?>" class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
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

	<span class="<?php echo $inputContainerClasses; ?>">

			<span class="wfFieldSimpleCaptchaCalculation"><?php echo $firstArgument; ?><?php echo $operator; ?><?php echo $secondArgument; ?> =</span>
			<input id="<?php echo $id; ?>"
				   name="<?php echo $id; ?>"
				   type="text"
				   value=""
				   class="<?php echo $inputClasses; ?>"
			/>

		<input type="hidden" name="<?php echo $id; ?>_result" value="<?php echo $result; ?>" />
	</span>

	<?php if (strlen($label) > 0 && $labelLocation == 'bottom') { ?>
		<label for="<?php echo $id; ?>" class="<?php echo $labelClasses; ?>" style="<?php echo $labelStyles; ?>">
			<?php echo $label; ?><?php if ($required) { ?><span class="wfFieldLabelRequiredMark">*</span><?php } ?>
		</label>
	<?php } ?>
</div>