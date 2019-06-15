<?php
/**
 * WP_Framework_Editor Classes Models Editor
 *
 * @version 0.0.1
 * @author Technote
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space
 */

namespace WP_Framework_Editor\Classes\Models;

use WP_Framework_Core\Traits\Hook;
use WP_Framework_Core\Traits\Singleton;
use WP_Framework_Editor\Traits\Package;

if ( ! defined( 'WP_CONTENT_FRAMEWORK' ) ) {
	exit;
}

/**
 * Class Editor
 * @package WP_Framework_Editor\Classes\Models
 */
class Editor implements \WP_Framework_Core\Interfaces\Singleton, \WP_Framework_Core\Interfaces\Hook {

	use Singleton, Hook, Package;

	/**
	 * @return bool
	 */
	protected static function is_shared_class() {
		return true;
	}

	/**
	 * @return bool
	 */
	public function is_valid_tinymce_color_picker() {
		return $this->compare_wp_version( '4.0.0', '>=' );
	}

	/**
	 * @return bool
	 */
	public function can_use_block_editor() {
		return $this->compare_wp_version( '5.0.0', '>=' );
	}

	/**
	 * @return bool
	 */
	public function is_block_editor() {
		if ( ! is_admin() ) {
			return false;
		}

		if ( $this->can_use_block_editor() ) {
			return get_current_screen()->is_block_editor();
		}

		/** @noinspection PhpDeprecationInspection */
		return function_exists( 'is_gutenberg_page' ) && is_gutenberg_page();
	}
}
