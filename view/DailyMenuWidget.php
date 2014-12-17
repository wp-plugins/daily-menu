<?php
/**
 * Adds Foo_Widget widget.
 */
class DailyMenuWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
				'dmWidget', // Base ID
				__( 'Daily Menu', DM_DOMAIN_NAME), // Name
				array( 'description' => __( 'Daily Menu Widget shows the menu of the day', DM_DOMAIN_NAME), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$nextMenu = ListMenus::getNextMenu();

		$day = new DateTime($nextMenu->getDate());
		$html .= "<t1>".__($day->format("l"),DM_DOMAIN_NAME)."</t1>";
		
		$html .= "<dl>";
		
		// dish lines
		foreach ($types as $type => $typename) {
			$html .= "<dt>".$typename."</dt>";
			$html .= "<dd>".$nextMenu->getDish($type)->getName()."</dd>";
		}
		
		$html .= "</dl>";
		
		echo $html;

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

	}

}