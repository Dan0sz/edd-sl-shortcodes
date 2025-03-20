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
		add_shortcode( 'changelog', [ $this, 'render_changelog' ] );
		add_shortcode( 'edd_dl_version', [ $this, 'render_version' ] );
		add_shortcode( 'edd_dl_last_updated', [ $this, 'render_date_last_updated' ] );
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
				'id' => '0',
			],
			$atts,
			$tag
		);

		$post_meta = apply_filters( 'daan_changelog_contents', get_post_meta( $atts[ 'id' ], '_edd_sl_changelog' ) );

		$output = "<div class='daan-edd-changelog'>";

		foreach ( $post_meta as $meta ) {
			$output .= $meta;
		}

		$output .= "</div>";

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

		if ( ! $readme_url ) {
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
}