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
	 * @var Editor $_editor
	 */
	private static $_editor;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		static::$_editor = Editor::get_instance( static::$app );
	}

	public function test_is_valid_tinymce_color_picker() {
		global $wp_version;
		$tmp = $wp_version;

		$wp_version = '4.0.0';
		$this->assertTrue( static::$_editor->is_valid_tinymce_color_picker() );

		$wp_version = '3.9.3';
		$this->assertFalse( static::$_editor->is_valid_tinymce_color_picker() );

		$wp_version = $tmp;
	}

	public function test_can_use_block_editor() {
		global $wp_version;
		$tmp = $wp_version;

		$wp_version = '5.0.0';
		$this->assertTrue( static::$_editor->can_use_block_editor() );

		$wp_version = '4.9.9';
		$this->assertFalse( static::$_editor->can_use_block_editor() );

		$wp_version = $tmp;
	}

	public function test_get_wp_editor_package_versions() {
		$versions = static::$_editor->get_wp_editor_package_versions();
		$this->assertNotEmpty( $versions );
		foreach ( $versions as $package => $version ) {
			$this->assertEquals( 1, preg_match( '#\Awp-#', $package ) );
			$this->assertNotEmpty( $version );
			$this->assertTrue( is_string( $version ) );
		}
	}

	public function test_get_gutenberg_package_versions() {
		$versions = static::$_editor->get_gutenberg_package_versions();
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