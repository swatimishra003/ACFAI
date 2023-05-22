<?php
/**
 * 
 * This plugin ordered by a client and done by Swati Mishra. Authority dedicated to that cient.
 *
 * @wordpress-plugin
 * Plugin Name:       AI Content Generator on ACF field
 * Plugin URI:        https://github.com/swatimishra003/ACFAI/
 * Description:       Introducing the AI Content Generator plugin for ACF in WordPress! Effortlessly generate unique and engaging content for your website with the power of artificial intelligence. Simply input your desired topic and let the plugin do the rest. Save time and boost your content game today!
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Swati Mishra
 * Author URI:        https://github.com/swatimishra003/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ai-content-generator-on-acf-field
 * Domain Path:       /languages
 * 
 */

/**
 * Bootstrap the plugin.
 */



defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR__FILE__' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR__FILE__', untrailingslashit( __FILE__ ) );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH', untrailingslashit( plugin_dir_path( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR__FILE__ ) ) );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_URI', untrailingslashit( plugin_dir_url( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR__FILE__ ) ) );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_URI ) . '/assets/build' );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_PATH' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_PATH', untrailingslashit( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH ) . '/assets/build' );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_URI ) . '/assets/build/js' );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH', untrailingslashit( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH ) . '/assets/build/js' );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_IMG_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_IMG_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_URI ) . '/assets/build/src/img' );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_URI ) . '/assets/build/css' );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_DIR_PATH' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_DIR_PATH', untrailingslashit( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH ) . '/assets/build/css' );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_URI ) . '/assets/build/library' );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_ARCHIVE_POST_PER_PAGE' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_ARCHIVE_POST_PER_PAGE', 9 );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_SEARCH_RESULTS_POST_PER_PAGE' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_SEARCH_RESULTS_POST_PER_PAGE', 9 );
defined( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_OPTIONS' ) || define( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_OPTIONS', get_option( 'ai-content-generator-on-acf-field' ) );

require_once FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH . '/inc/helpers/autoloader.php';
// require_once FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH . '/inc/helpers/template-tags.php';

if( ! function_exists( 'FutureWordPressProjectAIContentGenerator_get_theme_instance' ) ) {
	function FutureWordPressProjectAIContentGenerator_get_theme_instance() {\FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Project::get_instance();}
}
FutureWordPressProjectAIContentGenerator_get_theme_instance();



