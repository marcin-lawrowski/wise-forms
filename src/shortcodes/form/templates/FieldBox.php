<div class="wfFieldContainer wfField<?php echo ucfirst($type); ?>Container <?php echo $id; ?>Container <?php echo $hasErrors ? 'wfFieldValidationError' : ''; ?>">
	<?php echo $body; ?>
	<?php foreach ($errors as $error) { ?>
		<p class="wfValidationErrorMessage"><?php echo $error; ?></p>
	<?php } ?>
</div>
