<?php
/**
 * WP_Framework_Editor Models Editor Test
 *
 * @author Technote
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space
 */

namespace WP_Framework_Editor\Tests\Models;

use WP_Framework_Editor\Classes\Models\Editor;
use WP_Framework_Editor\Tests\TestCase;

/**
 * Class EditorTest
 * @package WP_Framework_Editor\Tests\Models
 * @group wp_framework
 * @group models
 */
class EditorTest extends TestCase {

	/**
	 * @var Editor $editor
	 */
	private static $editor;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		static::$editor = Editor::get_instance( static::$app );
	}

	public function test_is_valid_tinymce_color_picker() {
		global $wp_version;
		$tmp = $wp_version;

		$wp_version = '4.0.0'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$this->assertTrue( static::$editor->is_valid_tinymce_color_picker() );

		$wp_version = '3.9.3'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$this->assertFalse( static::$editor->is_valid_tinymce_color_picker() );

		$wp_version = $tmp; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}

	public function test_can_use_block_editor() {
		global $wp_version;
		$tmp = $wp_version;

		$wp_version = '5.0.0'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$this->assertTrue( static::$editor->get_packages_helper()->get_gutenberg_helper()->can_use_block_editor() );

		$wp_version = '4.9.9'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$this->assertFalse( static::$editor->get_packages_helper()->get_gutenberg_helper()->can_use_block_editor() );

		$wp_version = $tmp; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}

	public function test_get_wp_editor_package_versions() {
		$versions = static::$editor->get_wp_core_package_versions();
		$this->assertNotEmpty( $versions );
		foreach ( $versions as $package => $version ) {
			$this->assertEquals( 1, preg_match( '#\Awp-#', $package ) );
			$this->assertNotEmpty( $version );
			$this->assertTrue( is_string( $version ) );
		}
	}

	public function test_get_gutenberg_package_versions() {
		$versions = static::$editor->get_gutenberg_package_versions();
		if ( false !== $versions ) {
			$this->assertNotEmpty( $versions );
			foreach ( $versions as $package => $version ) {
				$this->assertEquals( 1, preg_match( '#\Awp-#', $package ) );
				$this->assertNotEmpty( $version );
				$this->assertTrue( is_string( $version ) );
			}
		}
	}
}
