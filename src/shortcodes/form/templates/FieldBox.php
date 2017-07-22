<div class="wfFieldContainer wfField<?php echo ucfirst($type); ?>Container <?php echo $id; ?>Container <?php echo $hasErrors ? 'wfFieldValidationError' : ''; ?>">
	<?php echo $body; ?>
	<?php if (isset($description) && strlen($description) > 0) { ?>
		<p class="wfFieldDescription"><?php echo $description; ?></p>
	<?php } ?>
	<?php foreach ($errors as $error) { ?>
		<p class="wfValidationErrorMessage"><?php echo $error; ?></p>
	<?php } ?>
</div>
