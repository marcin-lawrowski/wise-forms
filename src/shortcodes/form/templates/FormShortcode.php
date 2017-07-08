<?php
/** @var string $fieldsRendered */
/** @var WiseFormsForm $form */
/** @var boolean $submitted */
/** @var boolean $hasErrors */
/** @var array $errors */
?>
<?php
	$formPublicId = base64_encode(WiseFormsCrypt::encrypt($form->getId()));
?>
<h1><?php echo $form->getName(); ?></h1>

<?php if (!$submitted) { ?>
	<form class="wfForm" method="post">
		<?php wp_nonce_field('wfSendFormNonceValue','wfSendFormNonce'); ?>
		<input type="hidden" name="wfSendForm" value="<?php echo $formPublicId; ?>" />
		<?php if ($hasErrors) { ?>
			<h3 class="wfFormSubmissionError"><?php echo $form->getMessage('form.submission.error'); ?></h3>
		<?php } ?>
		<?php if (array_key_exists('form', $errors)) { ?>
			<?php foreach ($errors['form'] as $error) { ?>
				<h4 class="wfFormSubmissionError"><?php echo $error; ?></h4>
			<?php } ?>
		<?php } ?>
		<?php echo $fieldsRendered; ?>
	</form>
<?php } else { ?>
	<h2><?php echo $form->getMessage('form.submitted'); ?></h2>
<?php } ?>
