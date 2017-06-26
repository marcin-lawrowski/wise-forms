<?php
/** @var string $fieldsRendered */
/** @var WiseFormsForm $form */
/** @var boolean $submitted */
/** @var boolean $hasErrors */
?>
<h1><?php echo $form->getName(); ?></h1>

<?php if (!$submitted) { ?>
	<form class="wfForm" method="post">
		<input type="hidden" name="wfSendForm" value="ok" />
		<?php if ($hasErrors) { ?>
			<h3 class="wfFormSubmissionError"><?php echo $form->getMessage('form.submission.error'); ?></h3>
		<?php } ?>
		<?php echo $fieldsRendered; ?>
	</form>
<?php } else { ?>
	<h2><?php echo $form->getMessage('form.submitted'); ?></h2>
<?php } ?>
