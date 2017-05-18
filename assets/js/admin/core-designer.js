/**
 * Wise Forms Core namespace.
 *
 * @author Kainex <contact@kaine.pl>
 * @see http://kaine.pl
 */

var wiseforms = wiseforms || {};
wiseforms.admin = wiseforms.admin || {};
wiseforms.admin.core = wiseforms.admin.core || {};

/**
 * Instance class.
 *
 * @param {Object} options Plugin's global options
 * @constructor
 */
wiseforms.admin.core.Designer = function(options) {
	var container = options.container;
	var fieldTypes = wiseforms.admin.core.Fields;
	var fieldsContainer = container.find(".wfDesignerForm > .wfDesignerFieldsContainer");
	var fieldsTemplatesList = container.find(".wfDesignerFieldTemplate");

	fieldsContainer.sortable({
		placeholder: "ui-state-highlight",
		revert: true,
		update: function(event, ui) {
			updateFieldPreviewFromTemplate(ui.item);
		}
	});

	fieldsTemplatesList.draggable({
		connectToSortable: ".wfDesignerFieldsContainer",
		helper: "clone",
		revert: "invalid"
	});

	function getCurrentProperties(fieldInstance) {
		var currentProperties = fieldInstance.data('properties');
		if (!jQuery.isPlainObject(currentProperties)) {
			currentProperties = {};
		}

		return currentProperties;
	}

	function onFieldInstanceClick(e) {
		e.stopPropagation();
		var fieldInstance = jQuery(this).closest('.wfFieldInstance');
		var fieldType = fieldInstance.data('type');
		var propertiesContainer = container.find('.wfDesignerFieldInstanceProperties');

		var fieldConfiguration = getFieldConfigurationByType(fieldType);
		if (fieldConfiguration != null && typeof fieldConfiguration.propertiesTemplateElementId !== 'undefined') {
			var templateElement = jQuery('#' + fieldConfiguration.propertiesTemplateElementId);

			// render properties form:
			propertiesContainer.find('.wfDesignerToolBoxContent').html(templateElement.html());
			propertiesContainer.find('h4').text(fieldConfiguration.name + ' Properties');
			propertiesContainer.show();

			function storeValueAndRender(propertyName, propertyValue, fieldInstance) {
				var currentProperties = getCurrentProperties(fieldInstance);

				currentProperties[propertyName] = propertyValue;
				fieldInstance.data('properties', jQuery.extend(true, {}, currentProperties));

				// refresh the instance of the field:
				if (typeof fieldConfiguration.renderFromProperties !== 'undefined') {
					fieldConfiguration.renderFromProperties(currentProperties, fieldInstance);
				}

			}

			// text property:
			propertiesContainer.find('input[type="text"]').keyup(function(e) {
				var element = jQuery(event.target);
				storeValueAndRender(element.attr('name'), element.val(), fieldInstance);
			});

			// checkbox property:
			propertiesContainer.find('input[type="checkbox"]').change(function(e) {
				var element = jQuery(event.target);
				storeValueAndRender(element.attr('name'), element.is(':checked'), fieldInstance);
			});

			// radio property:
			propertiesContainer.find('input[type="radio"]').change(function(e) {
				var element = jQuery(event.target);
				var name = element.attr('name');
				storeValueAndRender(name, propertiesContainer.find('input[name="' + name + '"]').filter(':checked').val(), fieldInstance);
			});

			// select property:
			propertiesContainer.find('select').change(function(e) {
				var element = jQuery(event.target);
				storeValueAndRender(element.attr('name'), element.val(), fieldInstance);
			});

			// render properties form on click:
			if (typeof fieldConfiguration.renderPropertiesForm !== 'undefined') {
				fieldConfiguration.renderPropertiesForm(getCurrentProperties(fieldInstance), propertiesContainer);
			}

		} else {
			propertiesContainer.hide();
			propertiesContainer.find('.wfDesignerToolBoxContent').empty();
		}
	}

	function getFieldConfigurationByType(type) {
		var fieldTypesFound = fieldTypes.filter(function(fieldConfiguration) {
			return fieldConfiguration.type == type;
		});

		if (fieldTypesFound.length > 0) {
			return fieldTypesFound[0];
		}

		return null;
	}

	function removeFieldsHint() {
		fieldsContainer.removeClass('wfDesignerFieldsContainerHinted');
		fieldsContainer.find('li.wfDesignerFieldsHint').remove();
	}

	function updateFieldPreviewFromTemplate(element) {
		var fieldType = element.data('field-template-type');
		if (typeof fieldType !== 'undefined' && fieldType !== null) {
			var fieldInstance = getFieldInstance(fieldType);

			if (fieldInstance !== null) {
				// remove hint:
				removeFieldsHint();

				// add field:
				element.replaceWith(fieldInstance);
				element.data('field-template-type', null);
			} else {
				element.remove();
			}
		}
	}

	function getFieldInstance(type, initialProperties) {
		var fieldConfiguration = getFieldConfigurationByType(type);

		if (fieldConfiguration != null) {
			var templateElement = jQuery('#' + fieldConfiguration.templateElementId);

			if (templateElement.length > 0) {
				var fieldInstance = jQuery('<li>');
				fieldInstance.addClass('ui-state-default');
				fieldInstance.addClass('wfFieldInstance');
				fieldInstance.append(templateElement.html());
				fieldInstance.data('type', type);
				fieldInstance.click(onFieldInstanceClick);

				// propare for any container-type fields:
				fieldInstance.find(".wfDesignerFieldsContainer").sortable({
					placeholder: "ui-state-highlight",
					revert: false,
					update: function(event, ui) {
						updateFieldPreviewFromTemplate(ui.item);
					}
				});

				// get initial properties:
				if (typeof initialProperties === 'undefined') {
					initialProperties = fieldConfiguration.initialProperties;
				}

				// set properties of the field instance:
				if (typeof initialProperties !== 'undefined') {
					fieldInstance.data('properties', jQuery.extend(true, {}, initialProperties));

					// render the field instance from properties:
					if (typeof fieldConfiguration.renderFromProperties !== 'undefined') {
						fieldConfiguration.renderFromProperties(initialProperties, fieldInstance);
					}
				}

				return fieldInstance;
			}
		}

		return null;
	}

	function onSaveForm() {
		var fields = [];

		scanFormForConfiguration(container.find('.wfDesignerForm'), fields);

		console.log(fields);
	}

	function scanFormForConfiguration(element, fields) {
		element.children().each(function() {
			var current = jQuery(this);
			if (current.hasClass('wfFieldInstance')) {
				var fieldConfiguration = getCurrentProperties(current);
				var fieldType = current.data('type');
				if (typeof fieldType === 'undefined') {
					fieldType = 'Unknown';
				}
				fieldConfiguration.type = fieldType;

				var subContainers = current.children('.wfDesignerFieldsContainer');
				if (subContainers.length > 0) {
					fieldConfiguration.children = [];

					subContainers.each(function() {
						var children = [];
						scanFormForConfiguration(jQuery(this), children);
						fieldConfiguration.children.push(children);
					});
				}

				fields.push(fieldConfiguration);
			} else {
				scanFormForConfiguration(current, fields);
			}
		});
	}

	function renderFieldsInContainer(parent, fields) {
		if (!jQuery.isArray(fields)) {
			return;
		}

		for (var x = 0; x < fields.length; x++) {
			var field = fields[x];
			var fieldInstance = getFieldInstance(field.type, field);

			if (fieldInstance !== null && typeof field.children !== 'undefined') {
				fieldInstance.children('.wfDesignerFieldsContainer').each(function(index) {
					var currentContainer = jQuery(this);
					if (typeof field.children[index] !== 'undefined') {
						renderFieldsInContainer(currentContainer, field.children[index]);
					}
				});
			}

			if (fieldInstance !== null) {
				removeFieldsHint();
				parent.append(fieldInstance);
			}
		}

	}

	function initialize() {
		// render fields on init:
		renderFieldsInContainer(container.find('.wfDesignerFieldsContainer'), options.fields);

		options.formElement.submit(function() {
			var fields = [];
			scanFormForConfiguration(container.find('.wfDesignerForm'), fields);
			options.formElement.find('[name="fields"]').val(JSON.stringify(fields));
		});
	}

	container.find('.wfSaveForm').click(onSaveForm);

	// start the designer:
	initialize();
};