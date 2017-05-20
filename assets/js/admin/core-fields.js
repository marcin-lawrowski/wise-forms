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
			fieldInstance.find('input').attr('placeholder', properties.placeholder);
			fieldInstance.find('.wfFieldPropertyLabel').text(properties.label);

			fieldInstance.find('label').css('width', properties.labelWidth.length > 0 ? properties.labelWidth : 'auto');
			fieldInstance.find('label').css('display', properties.labelWidth.length > 0 ? 'inline-block' : 'inline');
			fieldInstance.find('label').css('text-align', properties.labelAlign);

			fieldInstance.find('.wfFieldPropertyRequired').toggleClass('wfHidden', !properties.required);
			fieldInstance.find('br').toggleClass('wfHidden', properties.labelLocation != 'top' || properties.label.length == 0 && !properties.required);
			fieldInstance.find('label').toggleClass('wfHidden', properties.label.length == 0 && !properties.required);
			fieldInstance.children('span').toggleClass('wf100RemaingWidth', properties.width == '100%');
			fieldInstance.find('label').toggleClass('wfLeft', properties.labelLocation != 'top' && properties.width == '100%');
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('input[name="placeholder"]').val(properties.placeholder);
			propertiesFormInstance.find('input[name="label"]').val(properties.label);
			propertiesFormInstance.find('input[name="labelWidth"]').val(properties.labelWidth);
			propertiesFormInstance.find('input[name="required"]').prop('checked', properties.required);
			propertiesFormInstance.find('input[name="labelLocation"][value="' + properties.labelLocation + '"]').prop("checked", true);
			propertiesFormInstance.find('select[name="width"]').val(properties.width);
			propertiesFormInstance.find('select[name="labelAlign"]').val(properties.labelAlign);
		},

		initialProperties: {
			label: 'Text:',
			placeholder: 'Enter text here',
			required: true,
			labelLocation: 'top',
			width: 'auto',
			labelWidth: '',
			labelAlign: 'left'
		}
	},
	{
		type: 'textArea',
		name: 'Text Area',
		templateElementId: 'textAreaTemplate',
		propertiesTemplateElementId: 'textAreaTemplateProperties',

		renderFromProperties: function(properties, fieldInstance) {
			fieldInstance.find('textarea').attr('placeholder', properties.placeholder);
			fieldInstance.find('.wfFieldPropertyLabel').text(properties.label);

			fieldInstance.find('label').css('width', properties.labelWidth.length > 0 ? properties.labelWidth : 'auto');
			fieldInstance.find('label').css('display', properties.labelWidth.length > 0 ? 'inline-block' : 'inline');
			fieldInstance.find('label').css('text-align', properties.labelAlign);

			fieldInstance.find('.wfFieldPropertyRequired').toggleClass('wfHidden', !properties.required);
			fieldInstance.find('br').toggleClass('wfHidden', properties.labelLocation != 'top' || properties.label.length == 0 && !properties.required);
			fieldInstance.find('label').toggleClass('wfHidden', properties.label.length == 0 && !properties.required);
			fieldInstance.children('span').toggleClass('wf100RemaingWidth', properties.width == '100%');
			fieldInstance.find('label').toggleClass('wfLeft', properties.labelLocation != 'top' && properties.width == '100%');
			fieldInstance.find('textarea').css('height', properties.height);
		},

		renderPropertiesForm: function(properties, propertiesFormInstance) {
			propertiesFormInstance.find('input[name="placeholder"]').val(properties.placeholder);
			propertiesFormInstance.find('input[name="label"]').val(properties.label);
			propertiesFormInstance.find('input[name="labelWidth"]').val(properties.labelWidth);
			propertiesFormInstance.find('input[name="required"]').prop('checked', properties.required);
			propertiesFormInstance.find('input[name="labelLocation"][value="' + properties.labelLocation + '"]').prop("checked", true);
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
			fieldInstance.find('p').text(properties.text);
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
	}

];