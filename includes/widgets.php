<?php

function google_review_widgets_init() {
	register_widget( 'Google_Reviews_Widget' );
}


class Google_Reviews_Widget extends WP_Widget {
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct( 'google_review_widget', 'Google Reviews', array(
			'description'	=> 'Displays the latest 5 reviews from Google'
		));
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget

		// Convert these two variables from arrays to a single variable
		extract( $args );
		extract( $instance );

		$title = apply_filters( 'widget_title', $title );

		echo $before_widget;
		echo $before_title . $title . $after_title;

		// Print a list of all latest google reviews (Google limits to 5)
		$reviews = get_transient( 'google_review_widget_contents' );

		foreach ($reviews as $review) {
			$review_date = (new DateTime($review->review_date))->format('Y-M-d');
			?>
			<p style="text-align: justify;">
				<strong><?php echo $review->review_name ?></strong>, rated <big><?php echo $review->review_rating ?></big>, on <small><strong><?php echo $review_date ?></strong></small>.<br>
				<?php echo stripslashes($review->review_text) ?><br>
				
			</p>
			
			<?php
		}

		echo $after_widget;


	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		$default	= array( 'title' => 'Latest Reviews From Google' );
		$instance 	= wp_parse_args( (array) $instance, $default );
		?>
		<p>
			<label  for="<?php echo $this->get_field_id( 'title');?>">Title</label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' );?>"
					name="<?php echo $this->get_field_name( 'title' );?>"
					value="<?php echo esc_attr( $instance['title'] ); ?>"> 
		</p>

		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance 			= array();
		$instance['title'] 	= strip_tags( $new_instance['title'] );
		return $instance;
	}
}