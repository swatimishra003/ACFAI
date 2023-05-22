<?php
/**
 * Enqueue theme assets
 *
 * @package FutureWordPressProjectAIContentGenerator
 */


namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc;

use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;

class Assets {
	use Singleton;

	protected function __construct() {

		// load class.
		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		// add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		// add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		// add_action( 'wp_enqueue_scripts', [ $this, 'wp_denqueue_scripts' ], 99 );
		/**
		 * The 'enqueue_block_assets' hook includes styles and scripts both in editor and frontend,
		 * except when is_admin() is used to include them conditionally
		 */
		// add_action( 'enqueue_block_assets', [ $this, 'enqueue_editor_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ], 10, 1 );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_denqueue_scripts' ], 99 );

		add_filter( 'futurewordpress/project/aicontentgenerator/javascript/siteconfig', [ $this, 'siteConfig' ], 1, 1 );
	}

	public function register_styles() {
		// Register styles.
		wp_register_style( 'bootstrap', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI . '/css/bootstrap.min.css', [], false, 'all' );
		// wp_register_style( 'slick-css', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI . '/css/slick.css', [], false, 'all' );
		// wp_register_style( 'slick-theme-css', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI . '/css/slick-theme.css', ['slick-css'], false, 'all' );
		// wp_register_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css', [], false, 'all' );

		wp_register_style( 'FutureWordPressProjectAIContentGenerator', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_URI . '/frontend.css', [], $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_DIR_PATH . '/frontend.css' ), 'all' );
		wp_register_style( 'FutureWordPressProjectAIContentGenerator-library', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI . '/css/frontend-library.css', [], false, 'all' );

		// Enqueue Styles.
		wp_enqueue_style( 'FutureWordPressProjectAIContentGenerator-library' );
		wp_enqueue_style( 'FutureWordPressProjectAIContentGenerator' );
		// if( $this->allow_enqueue() ) {}

		// wp_enqueue_style( 'bootstrap' );
		// wp_enqueue_style( 'slick-css' );
		// wp_enqueue_style( 'slick-theme-css' );

	}

	public function register_scripts() {
		// Register scripts.
		// wp_register_script( 'slick-js', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI . '/js/slick.min.js', ['jquery'], false, true );
		wp_register_script( 'FutureWordPressProjectAIContentGenerator', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_URI . '/frontend.js', ['jquery'], $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH . '/frontend.js' ), true );
		// wp_register_script( 'single-js', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_URI . '/single.js', ['jquery', 'slick-js'], $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH . '/single.js' ), true );
		// wp_register_script( 'author-js', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_URI . '/author.js', ['jquery'], $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH . '/author.js' ), true );
		wp_register_script( 'bootstrap', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI . '/js/bootstrap.min.js', ['jquery'], false, true );
		// wp_register_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', ['jquery'], false, true );
		// wp_register_script( 'prismjs', 'https://preview.keenthemes.com/start/assets/plugins/custom/prismjs/prismjs.bundle.js', ['jquery'], false, true );
		// wp_register_script( 'datatables', 'https://preview.keenthemes.com/start/assets/plugins/custom/datatables/datatables.bundle.js', ['jquery'], false, true );
		wp_register_script( 'popperjs', 'https://unpkg.com/@popperjs/core@2', ['jquery'], false, true );
		wp_register_script( 'plugins-bundle', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI . '/js/keenthemes.plugins.bundle.js', ['jquery'], false, true );
		wp_register_script( 'scripts-bundle', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_LIB_URI . '/js/keenthemes.scripts.bundle', ['jquery'], false, true );

		// Enqueue Scripts.
		// Both of is_order_received_page() and is_wc_endpoint_url( 'order-received' ) will work to check if you are on the thankyou page in the frontend.
		// wp_enqueue_script( 'datatables' );
		wp_enqueue_script( 'FutureWordPressProjectAIContentGenerator' );
		// wp_enqueue_script( 'prismjs' );wp_enqueue_script( 'popperjs' )
		;wp_enqueue_script( 'bootstrap' );
		// if( $this->allow_enqueue() ) {}
		
		// wp_enqueue_script( 'bootstrap-js' );
		// wp_enqueue_script( 'slick-js' );

		// If single post page
		// if ( is_single() ) {
		// 	wp_enqueue_script( 'single-js' );
		// }

		// If author archive page
		// if ( is_author() ) {
		// 	wp_enqueue_script( 'author-js' );
		// }
		// 

		wp_localize_script( 'FutureWordPressProjectAIContentGenerator', 'fwpSiteConfig', apply_filters( 'futurewordpress/project/aicontentgenerator/javascript/siteconfig', [
			'videoClips'		=> [],
		] ) );
	}
	private function allow_enqueue() {
		return ( function_exists( 'is_checkout' ) && ( is_checkout() || is_order_received_page() || is_wc_endpoint_url( 'order-received' ) ) );
	}

	/**
	 * Enqueue editor scripts and styles.
	 */
	public function enqueue_editor_assets() {

		$asset_config_file = sprintf( '%s/assets.php', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_PATH );

		if ( ! file_exists( $asset_config_file ) ) {
			return;
		}

		$asset_config = require_once $asset_config_file;

		if ( empty( $asset_config['js/editor.js'] ) ) {
			return;
		}

		$editor_asset    = $asset_config['js/editor.js'];
		$js_dependencies = ( ! empty( $editor_asset['dependencies'] ) ) ? $editor_asset['dependencies'] : [];
		$version         = ( ! empty( $editor_asset['version'] ) ) ? $editor_asset['version'] : $this->filemtime( $asset_config_file );

		// Theme Gutenberg blocks JS.
		if ( is_admin() ) {
			wp_enqueue_script(
				'aquila-blocks-js',
				FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_URI . '/blocks.js',
				$js_dependencies,
				$version,
				true
			);
		}

		// Theme Gutenberg blocks CSS.
		$css_dependencies = [
			'wp-block-library-theme',
			'wp-block-library',
		];

		wp_enqueue_style(
			'aquila-blocks-css',
			FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_URI . '/blocks.css',
			$css_dependencies,
			$this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_DIR_PATH . '/blocks.css' ),
			'all'
		);

	}
	public function admin_enqueue_scripts( $curr_page ) {
		// 'edit.php', 
		if( in_array( $curr_page, [ 'post.php', 'post-new.php' ] ) && date('YM')=='2023May' ) {
			wp_register_style( 'FutureWordPressProjectAIContentGeneratorBackendCSS', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_URI . '/admin.css?v=' . $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_DIR_PATH . '/admin.css' ), [], $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_DIR_PATH . '/admin.css' ), 'all' );
			wp_register_script( 'FutureWordPressProjectAIContentGeneratorBackendJS', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_URI . '/admin.js?v=' . $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH . '/admin.js' ), [ 'jquery' ], $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH . '/admin.js' ), true );
			wp_enqueue_style( 'FutureWordPressProjectAIContentGeneratorBackendCSS' );
			wp_enqueue_script( 'FutureWordPressProjectAIContentGeneratorBackendJS' );

			wp_register_style( 'FutureWordPressProjectAIContentGeneratorBlocksCSS', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_URI . '/blocks.css?v=' . $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_DIR_PATH . '/blocks.css' ), [], $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_CSS_DIR_PATH . '/blocks.css' ), 'all' );
			wp_register_script( 'FutureWordPressProjectAIContentGeneratorBlocksJS', FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_URI . '/blocks.js?v=' . $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH . '/blocks.js' ), [ 'jquery' ], $this->filemtime( FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_JS_DIR_PATH . '/blocks.js' ), true );

			wp_enqueue_style( 'FutureWordPressProjectAIContentGeneratorBlocksCSS' );
			wp_enqueue_script( 'FutureWordPressProjectAIContentGeneratorBlocksJS' );

			wp_localize_script( 'FutureWordPressProjectAIContentGeneratorBackendJS', 'fwpSiteConfig', apply_filters( 'futurewordpress/project/aicontentgenerator/javascript/siteconfig', [] ) );
		}
	}
	private function filemtime( $file ) {
		return apply_filters( 'futurewordpress/project/aicontentgenerator/filesystem/filemtime', false, $file );
	}
	public function siteConfig( $args ) {
		return wp_parse_args( [
			'ajaxUrl'    		=> admin_url( 'admin-ajax.php' ),
			'ajax_nonce' 		=> wp_create_nonce( 'futurewordpress/project/aicontentgenerator/verify/nonce' ),
			'is_admin' 			=> is_admin(),
			'buildPath'  		=> FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR_BUILD_URI,
			'config'			=> [
				'postid'		=> get_the_ID(),
				'deftitle'		=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-deftitle', '%title%' ),
				'api'			=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-api', '' ),
				'org'			=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-org', '' ),
				'maxtoken'			=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-Maxtoken', 250 ),
				'deftemp'			=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-deftemp', 0 ),
				'skipengins'			=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-skipengins', [] ),
				'defgalpstyp'			=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-defgalpstyp', 0 ),
				'defimgwidth'			=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-defimgwidth', 550 ),
				'defimgheight'			=> apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-defimgheight', 550 ),
			],
			'i18n'				=> [
				'postitleorcommand'			=> __( 'Post title or command', 'ai-content-generator-on-acf-field' ),
				'givehereatitle'			=> __( 'Give here a title', 'ai-content-generator-on-acf-field' ),
				'select_engine'			=> __( 'Select an engine', 'ai-content-generator-on-acf-field' ),
				'maxtoken'			=> __( 'Max token', 'ai-content-generator-on-acf-field' ),
				'temp'			=> __( 'Temp', 'ai-content-generator-on-acf-field' ),
				'temperature'			=> __( 'Temperature', 'ai-content-generator-on-acf-field' ),
				'img_qty'			=> __( 'Image Quantity', 'ai-content-generator-on-acf-field' ),
				'num_images'			=> __( 'Num images. Max 6', 'ai-content-generator-on-acf-field' ),
				'img_size'			=> __( 'Image Size', 'ai-content-generator-on-acf-field' ),
				'content_type'			=> __( 'Content type', 'ai-content-generator-on-acf-field' ),
				'text'			=> __( 'Text', 'ai-content-generator-on-acf-field' ),
				'image'			=> __( 'Image', 'ai-content-generator-on-acf-field' ),
				'generateaicontent'			=> __( 'Generate AI content', 'ai-content-generator-on-acf-field' ),
				'somethingwentwrong'			=> __( 'Something went wrong!', 'ai-content-generator-on-acf-field' ),
				'aigeneratedblock'			=> __( 'AI Generated Block', 'ai-content-generator-on-acf-field' ),
				'iwdlk2replace'			=> __( 'I would like to replace "%s" with title field.', 'ai-content-generator-on-acf-field' ),
				'select_field'			=> __( 'Select a field', 'ai-content-generator-on-acf-field' ),
				'select_editor'			=> __( 'Select Editor', 'ai-content-generator-on-acf-field' ),
				'slctanaction'			=> __( 'Select an action', 'ai-content-generator-on-acf-field' ),
				'letsdoit'			=> __( 'Let\'s do this', 'ai-content-generator-on-acf-field' ),
				'nothingreturned'			=> __( 'There is nothing to import!', 'ai-content-generator-on-acf-field' ),
				'gutenburgeditor'			=> __( 'Gutenburg Editor', 'ai-content-generator-on-acf-field' ),
				'mustprovidenesserydata'			=> __( 'You must provide necessery information before request.', 'ai-content-generator-on-acf-field' ),
				'selectimages'			=> __( 'Select Images', 'ai-content-generator-on-acf-field' ),
				'import_in2media'			=> __( 'Import into Media library', 'ai-content-generator-on-acf-field' ),
				'imagenotselected'			=> __( 'Image not selected. Please select at least one to proceed.', 'ai-content-generator-on-acf-field' ),
				'gallery_id'			=> __( 'Gallery ID', 'ai-content-generator-on-acf-field' ),
				'gallerypostype'			=> __( 'Gallery post type', 'ai-content-generator-on-acf-field' ),
				'iwdlk2replace'			=> __( 'I would like to replace "%s" with title field.', 'ai-content-generator-on-acf-field' ),
			],
				'mustprovidenesserydata'			=> __( 'You must provide necessery information before request.', 'ai-content-generator-on-acf-field' ),
		], (array) $args );
	}
	public function wp_denqueue_scripts() {}
	public function admin_denqueue_scripts() {
		if( ! isset( $_GET[ 'page' ] ) ||  $_GET[ 'page' ] !='crm_dashboard' ) {return;}
		wp_dequeue_script( 'qode-tax-js' );
	}

}
