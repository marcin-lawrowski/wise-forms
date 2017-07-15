/**
 * Wise Forms Core.
 *
 * @author Kainex <contact@kaine.pl>
 * @see http://kaine.pl
 */

var wiseforms = wiseforms || {};
wiseforms.admin = wiseforms.admin || {};
wiseforms.admin.core = wiseforms.admin.core || {};

/**
 * Fields definitions.
 *
 * @type {*[]}
 */
wiseforms.admin.core.Fields = [
	{
		type: 'textInput',
		name: 'Text Input',
		templateElementId: 'textInputTemplate',
		propertiesTemplateElementId: 'textInputTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			// insert texts:
			fieldInstance.find('input').attr('placeholder', properties.placeholder);
			fieldInstance.find('.wfFieldPropertyLabel').text(properties.label);

			// inline mode:
			fieldInstance.children('div').toggleClass('wfTable', properties.labelLocation == 'inline' && properties.label.length > 0 && properties.labelWidth.length > 0);
			fieldInstance.find('label').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);
			fieldInstance.find('div > span').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);

			// label top / bottom mode:
			if (properties.labelLocation == 'bottom') {
				fieldInstance.find('label').before(fieldInstance.find('div > span'));
			} else {
				fieldInstance.find('label').after(fieldInstance.find('div > span'));
			}

			// label hide:
			fieldInstance.find('label').toggleClass('wfHidden', properties.label.length === 0);

			// label width:
			fieldInstance.find('label').css('width', properties.labelWidth.length > 0 ? properties.labelWidth : 'auto');

			// label align:
			fieldInstance.find('label').css('text-align', properties.labelAlign);

			// 100% width:
			fieldInstance.find('div > span').toggleClass('wfWidth100', properties.width == '100%');
			fieldInstance.find('input').toggleClass('wfWidth100', properties.width == '100%');

			// required indicator:
			fieldInstance.find('.wfFieldPropertyRequired').toggleClass('wfHidden', !properties.required);
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('input[name="placeholder"]').val(properties.placeholder);
			propertiesFormInstance.find('input[name="label"]').val(properties.label);
			propertiesFormInstance.find('input[name="labelWidth"]').val(properties.labelWidth);
			propertiesFormInstance.find('input[name="required"]').prop('checked', properties.required);
			propertiesFormInstance.find('select[name="labelLocation"]').val(properties.labelLocation);
			propertiesFormInstance.find('select[name="width"]').val(properties.width);
			propertiesFormInstance.find('select[name="labelAlign"]').val(properties.labelAlign);
			propertiesFormInstance.find('select[name="validation"]').val(properties.validation);
		},

		initialProperties: {
			label: 'Text:',
			placeholder: 'Enter text here',
			required: true,
			labelLocation: 'top',
			width: 'auto',
			labelWidth: '',
			labelAlign: 'left',
			validation: ''
		}
	},
	{
		type: 'textArea',
		name: 'Text Area',
		templateElementId: 'textAreaTemplate',
		propertiesTemplateElementId: 'textAreaTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			// insert texts:
			fieldInstance.find('textarea').attr('placeholder', properties.placeholder);
			fieldInstance.find('.wfFieldPropertyLabel').text(properties.label);

			// inline mode:
			fieldInstance.children('div').toggleClass('wfTable', properties.labelLocation == 'inline' && properties.label.length > 0 && properties.labelWidth.length > 0);
			fieldInstance.find('label').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);
			fieldInstance.find('div > span').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);

			// label top / bottom mode:
			if (properties.labelLocation == 'bottom') {
				fieldInstance.find('label').before(fieldInstance.find('div > span'));
			} else {
				fieldInstance.find('label').after(fieldInstance.find('div > span'));
			}

			// label hide:
			fieldInstance.find('label').toggleClass('wfHidden', properties.label.length === 0);

			// label width:
			fieldInstance.find('label').css('width', properties.labelWidth.length > 0 ? properties.labelWidth : 'auto');

			// label align:
			fieldInstance.find('label').css('text-align', properties.labelAlign);

			// 100% width:
			fieldInstance.find('div > span').toggleClass('wfWidth100', properties.width == '100%');
			fieldInstance.find('textarea').toggleClass('wfWidth100', properties.width == '100%');

			// required indicator:
			fieldInstance.find('.wfFieldPropertyRequired').toggleClass('wfHidden', !properties.required);

			// height:
			fieldInstance.find('textarea').css('height', properties.height);
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('input[name="placeholder"]').val(properties.placeholder);
			propertiesFormInstance.find('input[name="label"]').val(properties.label);
			propertiesFormInstance.find('input[name="labelWidth"]').val(properties.labelWidth);
			propertiesFormInstance.find('input[name="required"]').prop('checked', properties.required);
			propertiesFormInstance.find('select[name="labelLocation"]').val(properties.labelLocation);
			propertiesFormInstance.find('select[name="width"]').val(properties.width);
			propertiesFormInstance.find('input[name="height"]').val(properties.height == 'auto' ? '' : properties.height);
			propertiesFormInstance.find('select[name="labelAlign"]').val(properties.labelAlign);
		},

		initialProperties: {
			label: 'Text:',
			placeholder: 'Enter text here',
			required: true,
			labelLocation: 'top',
			width: 'auto',
			height: 'auto',
			labelWidth: '',
			labelAlign: 'left'
		}

	},
	{
		type: 'container2Cols',
		name: '2 Columns',
		templateElementId: 'container2ColsTemplate'
	},
	{
		type: 'paragraph',
		name: 'Paragraph',
		templateElementId: 'paragraphTemplate',
		propertiesTemplateElementId: 'paragraphTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			fieldInstance.find('p').html(typeof properties.text !== 'undefined' ? properties.text.replace(/\n/, '<br />') : '');
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('*[name="text"]').val(properties.text);
		},

		initialProperties: {
			text: 'Paragraph Text'
		}
	},
	{
		type: 'buttonSubmit',
		name: 'Button Submit',
		templateElementId: 'buttonSubmitTemplate',
		propertiesTemplateElementId: 'buttonSubmitTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			fieldInstance.find('input').attr('value', properties.label);
			fieldInstance.find('div').css('text-align', properties.align);
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('*[name="label"]').val(properties.label);
			propertiesFormInstance.find('*[name="align"]').val(properties.align);
		},

		initialProperties: {
			label: 'Submit',
			align: 'left'
		}
	},
	{
		type: 'dropDownList',
		name: 'Dropdown list',
		templateElementId: 'dropDownListTemplate',
		propertiesTemplateElementId: 'dropDownListTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			// render placeholder:
			if (properties.placeholder.length > 0) {
				var placeholderOption = fieldInstance.find('select > option.wfFieldPlaceholderOption');
				if (placeholderOption.length === 0) {
					placeholderOption = jQuery('<option>');
					placeholderOption.addClass('wfFieldPlaceholderOption');
					placeholderOption.attr('selected', 'selected');
					placeholderOption.attr('disabled', 'disabled');
					fieldInstance.find('select').prepend(placeholderOption);
				}
				placeholderOption.attr('value', '');
				placeholderOption.text(properties.placeholder);
			} else {
				fieldInstance.find('select > option.wfFieldPlaceholderOption').remove();
			}
			var optionsOffset = fieldInstance.find('select > option.wfFieldPlaceholderOption').length;

			// render options:
			var totalOptions = optionsOffset;
			if (jQuery.isArray(properties.options)) {
				totalOptions += properties.options.length;

				// create additional options:
				for (var x = fieldInstance.find('select > option').length; x < totalOptions; x++) {
					var newOption = jQuery('<option>');
					fieldInstance.find('select').append(newOption);
				}

				// update options:
				for (var y = 0; y < properties.options.length; y++) {
					fieldInstance.find('select option').eq(y + optionsOffset)
						.attr('value', properties.options[y].key)
						.text(properties.options[y].value);
				}

				// delete options:
				for (var z = fieldInstance.find('select > option').length; z > totalOptions; z--) {
					fieldInstance.find('select > option').eq(z - 1).remove();
				}
			} else {
				fieldInstance.find('select > option:not(.wfFieldPlaceholderOption)').remove();
			}

			// insert texts:
			fieldInstance.find('.wfFieldPropertyLabel').text(properties.label);

			// inline mode:
			fieldInstance.children('div').toggleClass('wfTable', properties.labelLocation == 'inline' && properties.label.length > 0 && properties.labelWidth.length > 0);
			fieldInstance.find('label').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);
			fieldInstance.find('div > span').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);

			// label top / bottom mode:
			if (properties.labelLocation == 'bottom') {
				fieldInstance.find('label').before(fieldInstance.find('div > span'));
			} else {
				fieldInstance.find('label').after(fieldInstance.find('div > span'));
			}

			// label hide:
			fieldInstance.find('label').toggleClass('wfHidden', properties.label.length === 0);

			// label width:
			fieldInstance.find('label').css('width', properties.labelWidth.length > 0 ? properties.labelWidth : 'auto');

			// label align:
			fieldInstance.find('label').css('text-align', properties.labelAlign);

			// 100% width:
			fieldInstance.find('div > span').toggleClass('wfWidth100', properties.width == '100%');
			fieldInstance.find('select').toggleClass('wfWidth100', properties.width == '100%');

			// required indicator:
			fieldInstance.find('.wfFieldPropertyRequired').toggleClass('wfHidden', !properties.required);
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('input[name="placeholder"]').val(properties.placeholder);
			propertiesFormInstance.find('input[name="label"]').val(properties.label);
			propertiesFormInstance.find('input[name="labelWidth"]').val(properties.labelWidth);
			propertiesFormInstance.find('input[name="required"]').prop('checked', properties.required);
			propertiesFormInstance.find('select[name="labelLocation"]').val(properties.labelLocation);
			propertiesFormInstance.find('select[name="width"]').val(properties.width);
			propertiesFormInstance.find('select[name="labelAlign"]').val(properties.labelAlign);

			var options = [];
			if (jQuery.isArray(properties.options)) {
				for (var y = 0; y < properties.options.length; y++) {
					options.push(properties.options[y].value);
				}
			}
			propertiesFormInstance.find('*[name="options"]').val(options.length > 0 ? options.join("\n") : '');
		},

		mapProperty: function(propertyName, propertyValue, fieldInstance) {
			if (propertyName === 'options') {
				var values = propertyValue.split("\n");
				if (propertyValue.length > 0) {
					propertyValue = [];
					for (var x = 0; x < values.length; x++) {
						propertyValue.push({
							key: values[x],
							value: values[x]
						});
					}
				} else {
					propertyValue = [];
				}
			}

			return propertyValue;
		},

		initialProperties: {
			label: 'Select:',
			placeholder: 'Select item ...',
			required: true,
			labelLocation: 'top',
			width: 'auto',
			labelWidth: '',
			labelAlign: 'left',
			options: [
				{
					key: "Option 1",
					value: "Option 1"
				},
				{
					key: "Option 2",
					value: "Option 2"
				},
				{
					key: "Option 3",
					value: "Option 3"
				}
			]
		}
	},
	{
		type: 'checkboxes',
		name: 'Checkboxes list',
		templateElementId: 'checkboxesTemplate',
		propertiesTemplateElementId: 'checkboxesTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			// render options:
			var totalOptions = 0;
			if (jQuery.isArray(properties.options)) {
				totalOptions += properties.options.length;

				// create additional options:
				for (var x = fieldInstance.find('span.wfFieldCheckboxesContainer > label').length; x < totalOptions; x++) {
					var newOption = jQuery('<label>').append(
						jQuery('<input>').attr('type', 'checkbox')
					).append(
						jQuery('<span>')
					);
					fieldInstance.find('span.wfFieldCheckboxesContainer').append(newOption);
				}

				// update options:
				for (var y = 0; y < properties.options.length; y++) {
					var theLabel = fieldInstance.find('span.wfFieldCheckboxesContainer > label').eq(y);
					theLabel.find('input').attr('value', properties.options[y].key);
					theLabel.find('span').text(properties.options[y].value + ' ');
				}

				// delete options:
				for (var z = fieldInstance.find('span.wfFieldCheckboxesContainer > label').length; z > totalOptions; z--) {
					fieldInstance.find('span.wfFieldCheckboxesContainer > label').eq(z - 1).remove();
				}
			} else {
				fieldInstance.find('span.wfFieldCheckboxesContainer > label').remove();
			}

			// set layout class:
			fieldInstance.find('span.wfFieldCheckboxesContainer')
				.removeClass('wfFieldLayout1col')
				.removeClass('wfFieldLayout2cols')
				.removeClass('wfFieldLayout3cols')
				.removeClass('wfFieldLayout4cols');
			if (typeof properties.layout !== 'undefined' && properties.layout.length > 0) {
				fieldInstance.find('span.wfFieldCheckboxesContainer').addClass('wfFieldLayout' + properties.layout);
			}

			// insert texts:
			fieldInstance.find('.wfFieldPropertyLabel').text(properties.label);

			// inline mode:
			fieldInstance.children('div').toggleClass('wfTable', properties.labelLocation == 'inline' && properties.label.length > 0 && properties.labelWidth.length > 0);
			fieldInstance.find('div > label').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);
			fieldInstance.find('div > span').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);

			// label top / bottom mode:
			if (properties.labelLocation == 'bottom') {
				fieldInstance.find('div > label').before(fieldInstance.find('div > span'));
			} else {
				fieldInstance.find('div > label').after(fieldInstance.find('div > span'));
			}

			// label hide:
			fieldInstance.find('div > label').toggleClass('wfHidden', properties.label.length === 0);

			// label width:
			fieldInstance.find('div > label').css('width', properties.labelWidth.length > 0 ? properties.labelWidth : 'auto');

			// label align:
			fieldInstance.find('div > label').css('text-align', properties.labelAlign);

			// required indicator:
			fieldInstance.find('.wfFieldPropertyRequired').toggleClass('wfHidden', !properties.required);
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('input[name="label"]').val(properties.label);
			propertiesFormInstance.find('input[name="labelWidth"]').val(properties.labelWidth);
			propertiesFormInstance.find('input[name="required"]').prop('checked', properties.required);
			propertiesFormInstance.find('select[name="labelLocation"]').val(properties.labelLocation);
			propertiesFormInstance.find('select[name="labelAlign"]').val(properties.labelAlign);
			propertiesFormInstance.find('select[name="layout"]').val(properties.layout);

			var options = [];
			if (jQuery.isArray(properties.options)) {
				for (var y = 0; y < properties.options.length; y++) {
					options.push(properties.options[y].value);
				}
			}
			propertiesFormInstance.find('*[name="options"]').val(options.length > 0 ? options.join("\n") : '');
		},

		mapProperty: function(propertyName, propertyValue, fieldInstance) {
			if (propertyName === 'options') {
				var values = propertyValue.split("\n");
				if (propertyValue.length > 0) {
					propertyValue = [];
					for (var x = 0; x < values.length; x++) {
						propertyValue.push({
							key: values[x],
							value: values[x]
						});
					}
				} else {
					propertyValue = [];
				}
			}

			return propertyValue;
		},

		initialProperties: {
			label: 'Select:',
			required: true,
			labelLocation: 'top',
			labelWidth: '',
			labelAlign: 'left',
			layout: '',
			options: [
				{
					key: "Option 1",
					value: "Option 1"
				},
				{
					key: "Option 2",
					value: "Option 2"
				},
				{
					key: "Option 3",
					value: "Option 3"
				}
			]
		}
	},
	{
		type: 'radioButtons',
		name: 'Radio buttons',
		templateElementId: 'radioButtonsTemplate',
		propertiesTemplateElementId: 'radioButtonsTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			// render options:
			var totalOptions = 0;
			if (jQuery.isArray(properties.options)) {
				totalOptions += properties.options.length;

				// create additional options:
				for (var x = fieldInstance.find('span.wfFieldCheckboxesContainer > label').length; x < totalOptions; x++) {
					var newOption = jQuery('<label>').append(
						jQuery('<input>').attr('type', 'radio').attr('name', 'wfFieldRadioName' + fieldInstance.data('id'))
					).append(
						jQuery('<span>')
					);
					fieldInstance.find('span.wfFieldCheckboxesContainer').append(newOption);
				}

				// update options:
				for (var y = 0; y < properties.options.length; y++) {
					var theLabel = fieldInstance.find('span.wfFieldCheckboxesContainer > label').eq(y);
					theLabel.find('input').attr('value', properties.options[y].key);
					theLabel.find('span').text(properties.options[y].value + ' ');
				}

				// delete options:
				for (var z = fieldInstance.find('span.wfFieldCheckboxesContainer > label').length; z > totalOptions; z--) {
					fieldInstance.find('span.wfFieldCheckboxesContainer > label').eq(z - 1).remove();
				}
			} else {
				fieldInstance.find('span.wfFieldCheckboxesContainer > label').remove();
			}

			// set layout class:
			fieldInstance.find('span.wfFieldCheckboxesContainer')
				.removeClass('wfFieldLayout1col')
				.removeClass('wfFieldLayout2cols')
				.removeClass('wfFieldLayout3cols')
				.removeClass('wfFieldLayout4cols');
			if (typeof properties.layout !== 'undefined' && properties.layout.length > 0) {
				fieldInstance.find('span.wfFieldCheckboxesContainer').addClass('wfFieldLayout' + properties.layout);
			}

			// insert texts:
			fieldInstance.find('.wfFieldPropertyLabel').text(properties.label);

			// inline mode:
			fieldInstance.children('div').toggleClass('wfTable', properties.labelLocation == 'inline' && properties.label.length > 0 && properties.labelWidth.length > 0);
			fieldInstance.find('div > label').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);
			fieldInstance.find('div > span').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);

			// label top / bottom mode:
			if (properties.labelLocation == 'bottom') {
				fieldInstance.find('div > label').before(fieldInstance.find('div > span'));
			} else {
				fieldInstance.find('div > label').after(fieldInstance.find('div > span'));
			}

			// label hide:
			fieldInstance.find('div > label').toggleClass('wfHidden', properties.label.length === 0);

			// label width:
			fieldInstance.find('div > label').css('width', properties.labelWidth.length > 0 ? properties.labelWidth : 'auto');

			// label align:
			fieldInstance.find('div > label').css('text-align', properties.labelAlign);

			// required indicator:
			fieldInstance.find('.wfFieldPropertyRequired').toggleClass('wfHidden', !properties.required);
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('input[name="label"]').val(properties.label);
			propertiesFormInstance.find('input[name="labelWidth"]').val(properties.labelWidth);
			propertiesFormInstance.find('input[name="required"]').prop('checked', properties.required);
			propertiesFormInstance.find('select[name="labelLocation"]').val(properties.labelLocation);
			propertiesFormInstance.find('select[name="labelAlign"]').val(properties.labelAlign);
			propertiesFormInstance.find('select[name="layout"]').val(properties.layout);

			var options = [];
			if (jQuery.isArray(properties.options)) {
				for (var y = 0; y < properties.options.length; y++) {
					options.push(properties.options[y].value);
				}
			}
			propertiesFormInstance.find('*[name="options"]').val(options.length > 0 ? options.join("\n") : '');
		},

		mapProperty: function(propertyName, propertyValue, fieldInstance) {
			if (propertyName === 'options') {
				var values = propertyValue.split("\n");
				if (propertyValue.length > 0) {
					propertyValue = [];
					for (var x = 0; x < values.length; x++) {
						propertyValue.push({
							key: values[x],
							value: values[x]
						});
					}
				} else {
					propertyValue = [];
				}
			}

			return propertyValue;
		},

		initialProperties: {
			label: 'Select:',
			required: true,
			labelLocation: 'top',
			labelWidth: '',
			labelAlign: 'left',
			layout: '',
			options: [
				{
					key: "Option 1",
					value: "Option 1"
				},
				{
					key: "Option 2",
					value: "Option 2"
				},
				{
					key: "Option 3",
					value: "Option 3"
				}
			]
		}
	},
	{
		type: 'simpleCaptcha',
		name: 'Simple Captcha',
		templateElementId: 'simpleCaptchaTemplate',
		propertiesTemplateElementId: 'simpleCaptchaTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			// insert texts:
			fieldInstance.find('.wfFieldPropertyLabel').text(properties.label);

			// inline mode:
			fieldInstance.children('div').toggleClass('wfTable', properties.labelLocation == 'inline' && properties.label.length > 0 && properties.labelWidth.length > 0);
			fieldInstance.find('label').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);
			fieldInstance.find('div > span').toggleClass('wfCell', properties.labelLocation == 'inline' && properties.label.length > 0);

			// label top / bottom mode:
			if (properties.labelLocation == 'bottom') {
				fieldInstance.find('label').before(fieldInstance.find('div > span'));
			} else {
				fieldInstance.find('label').after(fieldInstance.find('div > span'));
			}

			// label hide:
			fieldInstance.find('label').toggleClass('wfHidden', properties.label.length === 0);

			// label width:
			fieldInstance.find('label').css('width', properties.labelWidth.length > 0 ? properties.labelWidth : 'auto');

			// label align:
			fieldInstance.find('label').css('text-align', properties.labelAlign);

			// required indicator:
			fieldInstance.find('.wfFieldPropertyRequired').toggleClass('wfHidden', !properties.required);
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('input[name="label"]').val(properties.label);
			propertiesFormInstance.find('input[name="labelWidth"]').val(properties.labelWidth);
			propertiesFormInstance.find('input[name="required"]').prop('checked', properties.required);
			propertiesFormInstance.find('select[name="labelLocation"]').val(properties.labelLocation);
			propertiesFormInstance.find('select[name="labelAlign"]').val(properties.labelAlign);
		},

		initialProperties: {
			label: 'Calculate:',
			required: true,
			labelLocation: 'top',
			labelWidth: '',
			labelAlign: 'left'
		}
	}

];