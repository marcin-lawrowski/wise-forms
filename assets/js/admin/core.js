/**
 * WiseForms admin core JS.
 *
 * @author Kainex <contact@kaine.pl>
 */

jQuery(window).load(function() {
	var hashValue = window.location.hash ? window.location.hash.substr(1) : '';

	jQuery('.wfTabs').each(function() {
		var tabsElement = jQuery(this);
		var tabs = new CBPFWTabs(tabsElement[0]);

		if (hashValue.length > 0) {
			var index = tabsElement.find('nav ul li a').index(tabsElement.find('a[href="#' + hashValue + '"]'));
			tabs._show(index);
		}
	});

	// add tab name to forms:
	if (hashValue.length > 0) {
		var forms = jQuery('.wfAdminPage form');
		forms.append(
			jQuery('<input />')
				.attr('type', 'hidden')
				.attr('name', 'tab')
				.attr('value', hashValue)
		);
	}

	// detect hash change and update the hidden input:
	jQuery(window).on('hashchange', function() {
		var hash = window.location.hash ? window.location.hash.substr(1) : '';
		var forms = jQuery('.wfAdminPage form');
		if (forms.length > 0 && hash.length > 0) {
			var hiddenField = forms.find('input[name="tab"]');
			if (hiddenField.length === 0) {
				hiddenField = jQuery('<input />')
					.attr('type', 'hidden')
					.attr('name', 'tab');
				forms.append(hiddenField);
			}
			hiddenField.attr('value', hash);
		}
	});

});