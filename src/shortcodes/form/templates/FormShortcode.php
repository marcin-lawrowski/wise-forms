<?php
/** @var string $fieldsRendered */
/** @var WiseFormsForm $form */
/** @var boolean $submitted */
?>
<h1><?php echo $form->getName(); ?></h1>

<?php if (!$submitted) { ?>
	<form class="wfForm" method="post">
		<input type="hidden" name="wfSendForm" value="ok" />
		<?php echo $fieldsRendered; ?>
	</form>
<?php } else { ?>
	<h2><?php echo $form->getMessage('form.submitted'); ?></h2>
<?php } ?>
