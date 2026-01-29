<?php
/**
 * @package Daan\EDD\SoftwareLicensing
 * @author  Daan van den Bergh
 * @url     https://daan.dev
 * @license MIT
 */

namespace Daan\EDD\SoftwareLicensing;

class Shortcodes {
	/**
	 * Build class.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Action & filter hooks.
	 *
	 * @return void
	 */
	private function init() {
		/**
		 * Enqueue assets.
		 */
		add_action( 'wp_enqueue_scripts', [ $this, 'maybe_enqueue_assets' ] );

		/**
		 * Shortcodes
		 */
		add_shortcode( 'changelog', [ $this, 'render_changelog' ] );
		add_shortcode( 'edd_dl_version', [ $this, 'render_version' ] );
		add_shortcode( 'edd_dl_last_updated', [ $this, 'render_date_last_updated' ] );
		
		/**
		 * Changelog as a Service compatibility
		 */
		add_filter( 'daan_changelog_contents', [ $this, 'maybe_modify_output' ] );

		/**
		 * Render widget and changelog section.
		 */
		add_action( 'widgets_init', [ $this, 'register_widget' ] );
		add_action( 'wp_footer', [ $this, 'maybe_render_changelog_section' ] );
	}

	/**
	 * Assets are only enqueued if widget is active.
	 *
	 * @return void
	 */
	public function maybe_enqueue_assets() {
		if ( ! $this->is_widget_active() ) {
			return;
		}
		
		global $post;

		$filemtime = filemtime( plugin_dir_path( EDD_SL_SHORTCODES_PLUGIN_FILE ) . 'assets/css/view-changelog.min.css' );

		wp_enqueue_style( 'daan-edd-sl-view-changelog', plugin_dir_url( EDD_SL_SHORTCODES_PLUGIN_FILE ) . 'assets/css/view-changelog.min.css', [], $filemtime );

		$filemtime = filemtime( plugin_dir_path( EDD_SL_SHORTCODES_PLUGIN_FILE ) . 'assets/js/view-changelog.min.js' );

		wp_enqueue_script( 'daan-edd-sl-view-changelog', plugin_dir_url( EDD_SL_SHORTCODES_PLUGIN_FILE ) . 'assets/js/view-changelog.min.js', [], $filemtime, [ 'defer' => true ] );
	}

	/**
	 * Check if our widget is active on current page.
	 *
	 * @return false|string
	 */
	private function is_widget_active() {
		return is_active_widget( false, false, Widget::ID );
	}

	/**
	 * Renders the contents for the [changelog] shortcode.
	 *
	 * @param array  $atts
	 * @param null   $content
	 * @param string $tag
	 *
	 * @return string
	 */
	public function render_changelog( $atts = [], $content = null, $tag = '' ) {
		$atts = array_change_key_case( (array) $atts, CASE_LOWER );
		$atts = shortcode_atts(
			[
				'id'    => get_the_ID(),
				'title' => __( 'Changelog', 'daan-edd-sl' ),
			],
			$atts,
			$tag
		);

		$post_meta = apply_filters( 'daan_changelog_contents', get_post_meta( $atts[ 'id' ], '_edd_sl_changelog' ) );

		if ( ! $post_meta ) {
			return '';
		}

		$title  = $atts[ 'title' ];
		$output = "<div id='daan-edd-sl-changelog' class='daan-edd-sl-changelog' style='display: none;'>";
		$output .= "<header class='daan-edd-sl-changelog-header'>";
		$output .= "<div class='daan-edd-sl-changelog-title'>$title</div>";
		$output .= "<button id='daan-edd-sl-changelog-close'>×</button>";
		$output .= "</header>";
		$output .= "<div class='daan-edd-sl-changelog-content'>";
		$output .= is_array( $post_meta ) ? implode( '', $post_meta ) : $post_meta;
		$output .= "</div></div>";

		return $output;
	}

	/**
	 * Shortcode: EDD Download Version
	 * [edd_dl_version id="post_id"]
	 * "id": defaults to current post.
	 *
	 * @return string
	 */
	public function render_version( $attributes ) {
		$attributes = shortcode_atts(
			[
				'id' => get_the_ID(),
			],
			$attributes
		);

		return get_post_meta( $attributes[ 'id' ], '_edd_sl_version', true ) ?? '';
	}

	/**
	 * Shortcode: EDD Product Last Updated
	 * [edd_dl_last_updated id="post_id" format="date_format"]
	 * "id": defaults to current post
	 * "date_format": defaults to date_format option from wp_options table.
	 *
	 * @return string
	 */
	public function render_date_last_updated( $attributes ) {
		$attributes = shortcode_atts(
			[
				'id'     => get_the_ID(),
				'format' => get_option( 'date_format' ),
			],
			$attributes
		);

		$readme_url = get_post_meta( $attributes[ 'id' ], '_edd_readme_location', true ) ?? '';

		/**
		 * A bug in EDD (or EDD SL) causes the value to be saved as (string) "false" sometimes.
		 */
		if ( ! $readme_url || $readme_url === 'false' ) {
			return '';
		}

		$headers = get_headers( $readme_url );

		foreach ( $headers as $header ) {
			if ( strpos( $header, 'Last-Modified' ) !== false ) {
				$timestamp = strtotime( str_replace( 'Last-Modified: ', '', $header ) );

				return gmdate( $attributes[ 'format' ], $timestamp );
			}
		}

		return '';
	}
	
	/**
	 * @param $post_meta
	 *
	 * @return string|array
	 */
	public function maybe_modify_output( $post_meta ) {
		if ( defined( 'CAAS_VERSION' ) ) {
			global $post;
			
			$id = '';
			
			if ( $post instanceof \WP_Post ) {
				$id = $post->ID;
			}
			
			if ( ! $id ) {
				return $post_meta;
			}
			
			return do_shortcode( "[changelog_service edd_id=$id]" );
		}
		
		return $post_meta;
	}

	/**
	 * Register the widget.
	 *
	 * @return void
	 */
	public function register_widget() {
		register_widget( '\Daan\EDD\SoftwareLicensing\Widget' );
	}

	public function maybe_render_changelog_section() {
		if ( ! $this->is_widget_active() ) {
			return;
		}

		$changelog = new Changelog();
		$changelog->render();
	}
}