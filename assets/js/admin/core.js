/**
 * WiseForms admin core JS.
 *
 * @author Kainex <contact@kaine.pl>
 */

jQuery(window).load(function() {

	jQuery('.wfTabs').each(function() {
		new CBPFWTabs(jQuery(this)[0]);
	});

});