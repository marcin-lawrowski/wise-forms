<?php

/**
 * WiseForms widget.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsWidget extends WP_Widget {

	/**
	 * @var WiseFormsFormDAO
	 */
	private $formsDao;

	public function __construct() {
		$this->formsDao = WiseFormsContainer::get('dao/WiseFormsFormDAO');

		$widgetOps = array('classname' => 'WiseFormsWidget', 'description' => 'Displays a form provided by Wise Forms plugin' );
		parent::__construct('WiseFormsWidget', 'Wise Form', $widgetOps);
	}

	public function form($instance) {
		$forms = $this->formsDao->getAllNoLimit();
		$instance = wp_parse_args((array) $instance, array('formId' => ''));

		$formId = $instance['formId'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('formId'); ?>">
				Form:
				<select id="<?php echo $this->get_field_id('formId'); ?>" name="<?php echo $this->get_field_name('formId'); ?>">
					<?php foreach ($forms as $form) { ?>
						<option value="<?php echo $form->getId(); ?>" <?php echo $form->getId() == $formId ? 'selected' : ''; ?>><?php echo $form->getName(); ?> (#<?php echo $form->getId(); ?>)</option>
					<?php } ?>
				</select>
			</label>
		</p>
		<?php
	}

	public function update($newInstance, $oldInstance) {
		$instance = $oldInstance;
		$instance['formId'] = $newInstance['formId'];

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;

		/** @var WiseFormsFormShortcode $form */
		$form = WiseFormsContainer::get('shortcodes/form/WiseFormsFormShortcode');
		$formId = intval($instance['formId']);

		if ($formId > 0) {
			echo $form->render(array('id' => $formId));
		}

		echo $after_widget;
	}
}