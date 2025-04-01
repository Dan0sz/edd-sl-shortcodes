<?php
/**
 * @package Daan\EDD\SoftwareLicensing
 * @author  Daan van den Bergh
 * @url     https://daan.dev
 * @license MIT
 */

namespace Daan\EDD\SoftwareLicensing;

use WP_Widget;

class Widget extends WP_Widget {
	const ID = 'edd-sl-download-details';

	/**
	 * Build widget.
	 */
	function __construct() {
		parent::__construct(
			self::ID,
			__( 'Software Licensing Download Details', 'daan-edd-sl' ),
			[
				'description' => __( 'A widget which displays a Download\'s version number, date last updated and a link to the changelog.', 'daan-edd-sl' ),
			]
		);
	}

	/**
	 * Frontend layout.
	 *
	 * @param $args
	 * @param $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );

		// before and after widget arguments are defined by themes
		echo $args[ 'before_widget' ];
		?>
		<?php

		if ( ! empty( $title ) ) {
			echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];
		}
		?>
        <div>
			<?php $last_updated = do_shortcode( '[edd_dl_last_updated]' ); ?>
			<?php if ( ! empty( $last_updated ) ) : ?>
                <div class="daan-edd-sl-last-updated"><?php echo __( 'Last updated', 'daan-edd-sl' ) . ': ' . $last_updated; ?></div>
			<?php endif; ?>
            <span class="daan-edd-sl-current-version"><?php echo __( 'Current version', 'daan-edd-sl' ) . ': ' . do_shortcode( '[edd_dl_version]' ); ?></span>
            <a id="edd-sl-view-changelog" class="daan-edd-sl-view-changelog"><?php echo __( 'View changelog', 'daan-edd-sl' ); ?></a>
        </div>
		<?php

		echo $args[ 'after_widget' ];
	}

	/**
	 * Settings form.
	 *
	 * @param $instance
	 *
	 * @return void
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'New title', 'daan-edd-sl' );
		}

		// Widget admin form
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:', 'daan-edd-sl' ); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
        </p>
		<?php
	}

	/**
	 * Update settings.
	 *
	 * @param $new_instance
	 * @param $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance            = [];
		$instance[ 'title' ] = ( ! empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';

		return $instance;
	}
}
