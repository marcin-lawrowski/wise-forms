<?php include('parts/FieldsTemplates.php'); ?>
<?php include('parts/FieldPropertiesFormsTemplates.php'); ?>

<?php
	$fields = '[]';
	if (strlen($form->getFields()) > 0) {
		$fieldsDecoded = json_decode($form->getFields());
		if (json_last_error() === 0) {
			$fields = $form->getFields();
		}
	}
?>

<input type="hidden" id="fields" name="fields" value="<?php echo htmlentities($fields, ENT_QUOTES, 'UTF-8'); ?>" />

<script>
	jQuery(window).load(function() {
		var savedConfigJSON = <?php echo $fields; ?>;
		jQuery("ul, li").disableSelection();

		var options = {
			container: jQuery('.wfDesigner'),
			formElement: jQuery('.wfFormAddEdit'),
			fields: savedConfigJSON
		};

		new wiseforms.admin.core.Designer(options);
	});
</script>

<div class="wfDesigner">
	<div class='wfDesignerRight'>
		<div class="wfDesignerToolBox">
			<h4>Fields</h4>
			<div class="wfDesignerToolBoxContent">
				<ul>
					<li class="wfDesignerFieldTemplate wfIconTextInput" data-field-template-type="textInput">Text Input</li>
					<li class="wfDesignerFieldTemplate wfIconTextEditor" data-field-template-type="textArea">Text Area</li>
					<li class="wfDesignerFieldTemplate wfIcon2Columns" data-field-template-type="container2Cols">2 cols</li>
					<li class="wfDesignerFieldTemplate wfIconParagraph" data-field-template-type="paragraph">Paragraph</li>
					<li class="wfDesignerFieldTemplate wfIconSubmit" data-field-template-type="buttonSubmit">Submit button</li>
					<li class="wfDesignerFieldTemplate wfIconDropDownList" data-field-template-type="dropDownList">DropDown list</li>
					<li class="wfDesignerFieldTemplate wfIconCheckbox" data-field-template-type="checkboxes">Checkboxes list</li>
					<li class="wfDesignerFieldTemplate wfIconRadioButton" data-field-template-type="radioButtons">Radio button list</li>
					<li class="wfDesignerFieldTemplate wfIconSimpleCaptcha" data-field-template-type="simpleCaptcha">Simple Captcha</li>
				</ul>
			</div>
		</div>
		<br />
		<div class="wfDesignerToolBox wfDesignerFieldInstanceProperties">
			<h4>Field Properties</h4>
			<div class="wfDesignerToolBoxContent">
				<span class="wfDesignerFieldsInstancePropertiesHint">Click form field to edit</span>
			</div>
		</div>
	</div>
	<div class='wfDesignerLeft'>

	</div>
	<div class='wfDesignerCenter'>

		<div class="wfDesignerForm">
			<ul class="wfDesignerFieldsContainer wfDesignerFieldsContainerHinted">
				<li class="wfDesignerFieldsHint">Drop fields here</li>
			</ul>
		</div>
	</div>
	<br class="wfClear" />
</div>