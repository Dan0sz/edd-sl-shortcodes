<?php
/**
 * @package Daan\EDD\SoftwareLicensing
 * @author  Daan van den Bergh
 * @url     https://daan.dev
 * @license MIT
 */

namespace Daan\EDD\SoftwareLicensing;

class Changelog {
	/**
	 * Renders the Changelog, using its shortcode.
	 *
	 * @return void
	 */
	public function render() {
		echo do_shortcode( '[changelog]' );
	}
}