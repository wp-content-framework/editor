<?php
/**
 * WP_Framework_Editor Classes Models Editor
 *
 * @author Technote
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space
 */

namespace WP_Framework_Editor\Classes\Models;

use WP_Framework_Core\Traits\Hook;
use WP_Framework_Core\Traits\Singleton;
use WP_Framework_Editor\Traits\Package;
use Technote\GutenbergPackages;
use Technote\GutenbergHelper;
use Technote\Helper;

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
	 * @var string $_cache_key
	 */
	private $_cache_key;

	/** @var GutenbergPackages $package_helper */
	private $package_helper;

	/** @var GutenbergHelper $gutenberg_helper */
	private $gutenberg_helper;

	/** @var Helper $helper */
	private $helper;

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
		return $this->get_gutenberg_helper()->can_use_block_editor();
	}

	/**
	 * @return bool
	 */
	public function is_block_editor() {
		return $this->get_packages_helper()->is_block_editor();
	}

	/**
	 * @return array
	 */
	public function get_editor_package_versions() {
		$cache = $this->cache_get( 'versions', null, $this->get_cache_key() );
		if ( isset( $cache ) ) {
			return $cache;
		}

		$versions = $this->get_packages_helper()->get_editor_package_versions();
		$this->cache_set( 'versions', $versions, $this->get_cache_key() );

		return $versions;
	}

	/**
	 * @return array
	 */
	public function get_wp_editor_package_versions() {
		return $this->get_packages_helper()->get_wp_editor_package_versions();
	}

	/**
	 * @return array|false
	 */
	public function get_gutenberg_package_versions() {
		return $this->get_packages_helper()->get_gutenberg_package_versions();
	}

	/**
	 * @param string $package
	 *
	 * @return string|false
	 */
	public function get_editor_package_version( $package ) {
		return $this->get_packages_helper()->get_editor_package_version( $package );
	}

	/**
	 * @param string $package
	 *
	 * @return bool
	 */
	public function is_support_editor_package( $package ) {
		return $this->get_packages_helper()->is_support_editor_package( $package );
	}

	/**
	 * @return string
	 */
	private function get_cache_key() {
		if ( ! isset( $this->_cache_key ) ) {
			$this->_cache_key = sha1( json_encode( [
				$this->wp_version(),
				$this->get_gutenberg_helper()->get_gutenberg_version(),
			] ) );
		}

		return $this->_cache_key;
	}

	/**
	 * @return GutenbergPackages
	 */
	private function get_packages_helper() {
		if ( ! isset( $this->package_helper ) ) {
			$this->package_helper = new GutenbergPackages( $this->get_helper(), $this->get_gutenberg_helper() );
		}

		return $this->package_helper;
	}

	/**
	 * @return GutenbergHelper
	 */
	private function get_gutenberg_helper() {
		if ( ! isset( $this->gutenberg_helper ) ) {
			$this->gutenberg_helper = new GutenbergHelper( $this->get_helper() );
		}

		return $this->gutenberg_helper;
	}

	/**
	 * @return Helper
	 */
	private function get_helper() {
		if ( ! isset( $this->helper ) ) {
			$this->helper = new Helper();
		}

		return $this->helper;
	}
}
