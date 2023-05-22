<?php
/**
 * Theme Sidebars.
 *
 * @package FutureWordPressProjectAIContentGenerator
 */
namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc;
use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;
/**
 * Class Widgets.
 */
class Widgets {
		use Singleton;
	/**
	 * Construct method.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}
	/**
	 * To register action/filter.
	 *
	 * @return void
	 */
	protected function setup_hooks() {
		/**
		 * Actions
		 */
		// add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
		// add_action( 'widgets_init', [ $this, 'register_clock_widget' ] );
		/**
		 * Elementor Widgets register.
		 */
		// add_action( 'elementor/widgets/register', [ $this, 'register_elementor_widgets' ], 10, 1 );
		add_action( 'widgets_init', [ $this, 'register_gutenberg_widgets' ] );
	}
	/**
	 * Register widgets.
	 *
	 * @action widgets_init
	 */
	public function register_sidebars() {
		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', 'ai-content-generator-on-acf-field' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget widget-sidebar %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );
		register_sidebar( [
			'name'          => esc_html__( 'Footer', 'ai-content-generator-on-acf-field' ),
			'id'            => 'sidebar-2',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget widget-footer cell column %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		] );
	}
	public function register_clock_widget() {
		register_widget( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Clock_Widget' );
	}
	public function register_elementor_widgets( $widgets_manager ) {
		$file = FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH . '/inc/widgets/elementor/widget-custom-category.php';
		if( ! file_exists( $file ) ) {return;}
		include_once $file;
		$widgets_manager->register( new Widgets_CustomCategory() );
	}
	public function register_gutenberg_widgets() {
		require_once FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_DIR_PATH . '/inc/widgets/gutenburg/widget-aigeneratedblock.php';
		register_widget( 'FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Widgets\AIGeneratedBlock' );
	}
}
