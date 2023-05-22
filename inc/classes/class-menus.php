<?php
/**
 * Register Menus
 *
 * @package FutureWordPressProjectAIContentGenerator
 */
namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc;
use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;
class Menus {
	use Singleton;
	protected function __construct() {
		// load class.
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		/**
		 * Actions.
		 */
		// add_action( 'init', [ $this, 'register_menus' ] );
		
		add_filter( 'futurewordpress/project/aicontentgenerator/settings/general', [ $this, 'general' ], 10, 1 );
		add_filter( 'futurewordpress/project/aicontentgenerator/settings/fields', [ $this, 'menus' ], 10, 1 );
		// add_action( 'in_admin_header', [ $this, 'in_admin_header' ], 100, 0 );
	}
	public function register_menus() {
		register_nav_menus([
			'aquila-header-menu' => esc_html__( 'Header Menu', 'ai-content-generator-on-acf-field' ),
			'aquila-footer-menu' => esc_html__( 'Footer Menu', 'ai-content-generator-on-acf-field' ),
		]);
	}
	/**
	 * Get the menu id by menu location.
	 *
	 * @param string $location
	 *
	 * @return integer
	 */
	public function get_menu_id( $location ) {
		// Get all locations
		$locations = get_nav_menu_locations();
		// Get object id by location.
		$menu_id = ! empty($locations[$location]) ? $locations[$location] : '';
		return ! empty( $menu_id ) ? $menu_id : '';
	}
	/**
	 * Get all child menus that has given parent menu id.
	 *
	 * @param array   $menu_array Menu array.
	 * @param integer $parent_id Parent menu id.
	 *
	 * @return array Child menu array.
	 */
	public function get_child_menu_items( $menu_array, $parent_id ) {
		$child_menus = [];
		if ( ! empty( $menu_array ) && is_array( $menu_array ) ) {
			foreach ( $menu_array as $menu ) {
				if ( intval( $menu->menu_item_parent ) === $parent_id ) {
					array_push( $child_menus, $menu );
				}
			}
		}
		return $child_menus;
	}
	public function in_admin_header() {
		if( ! isset( $_GET[ 'page' ] ) || $_GET[ 'page' ] != 'crm_dashboard' ) {return;}
		
		remove_all_actions('admin_notices');
		remove_all_actions('all_admin_notices');
		// add_action('admin_notices', function () {echo 'My notice';});
	}
	/**
	 * Supply necessry tags that could be replace on frontend.
	 * 
	 * @return string
	 * @return array
	 */
	public function commontags( $html = false ) {
		$arg = [];$tags = [
			'username', 'sitename', 
		];
		if( $html === false ) {return $tags;}
		foreach( $tags as $tag ) {
			$arg[] = sprintf( "%s{$tag}%s", '<code>{', '}</code>' );
		}
		return implode( ', ', $arg );
	}
	public function contractTags( $tags ) {
		$arg = [];
		foreach( $tags as $tag ) {
			$arg[] = sprintf( "%s{$tag}%s", '<code>{', '}</code>' );
		}
		return implode( ', ', $arg );
	}

	/**
	 * WordPress Option page.
	 * 
	 * @return array
	 */
	public function general( $args ) {
		return [
			'page_title'					=> __( 'GPT-3 Config.', 'ai-content-generator-on-acf-field' ),
			'menu_title'					=> __( 'GPT-3 Config', 'ai-content-generator-on-acf-field' ),
			'role'							=> 'manage_options',
			'page_header'					=> __( 'Customize GPT-3 ACF field content generation from here.', 'ai-content-generator-on-acf-field' ),
			'page_subheader'				=> __( 'Your setting panel from where you can control and customize.', 'ai-content-generator-on-acf-field' ),
		];
	}
	public function menus( $args ) {
    	// get_FwpOption( 'key', 'default' ) | apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'key', 'default' )
		// is_FwpActive( 'key' ) | apply_filters( 'futurewordpress/project/aicontentgenerator/system/isactive', 'key' )
		$args = [];
		$args['gpt3'] = [
			'title'							=> __( 'General', 'ai-content-generator-on-acf-field' ),
			'description'					=> __( 'Generel fields comst commonly used to changed.', 'ai-content-generator-on-acf-field' ),
			'fields'						=> [
				[
					'id' 					=> 'gpt3-enable',
					'label'					=> __( 'Enable', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Mark to enable GPT-3 Contenet Generation.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'checkbox',
					'default'				=> true
				],
				[
					'id' 					=> 'gpt3-api',
					'label'					=> __( 'OpenAI API', 'ai-content-generator-on-acf-field' ),
					'description'			=> sprintf( __( 'An OpenAI API is required and you can find %s your API here%s', 'ai-content-generator-on-acf-field' ), '<a href="https://platform.openai.com/account/api-keys" target="_blank">', '</a>' ),
					'type'					=> 'text',
					'default'				=> ''
				],
				[
					'id' 					=> 'gpt3-org',
					'label'					=> __( 'Organization ID', 'ai-content-generator-on-acf-field' ),
					'description'			=>  __( 'API\'s organization ID that you set on openai api.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'text',
					'default'				=> ''
				],
				[
					'id' 					=> 'gpt3-screens',
					'label'					=> __( 'Post types', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Input all custom/post types, comma separated.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'text',
					'default'				=> 'post,page'
				],
				[
					'id' 					=> 'gpt3-deftitle',
					'label'					=> __( 'Default title', 'ai-content-generator-on-acf-field' ),
					'description'			=> sprintf( __( 'Default title that should include before and after command like %s. Here %s will replace the post title.', 'ai-content-generator-on-acf-field' ), '<code>Give me a content about "%title%", to post as a blog post on my site.</code>', '<code>%title%</code>' ),
					'type'					=> 'text',
					'default'				=> '%title%'
				],
				[
					'id' 					=> 'gpt3-defnumings',
					'label'					=> __( 'Default Images', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'How many images should be generated on popup to select. This could be changed anytime.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'number',
					'default'				=> 5
				],
				[
					'id' 					=> 'gpt3-Maxtoken',
					'label'					=> __( 'Max Token', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Default max token for popup field.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'number',
					'default'				=> 250
				],
				[
					'id' 					=> 'gpt3-deftemp',
					'label'					=> __( 'Default Temp', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Default temperature for popup field. A higher temperature value will result in more diverse and creative outputs, while a lower temperature value will result in more conservative and predictable outputs. Max 1 & min 0.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'number',
					'default'				=> 0.1
				],
				[
					'id' 					=> 'gpt3-defgalpstyp',
					'label'					=> __( 'Default Gallery', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Default Gallery post type that created from ACF.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'text',
					'default'				=> 'my_gallery'
				],
				[
					'id' 					=> 'gpt3-defimgwidth',
					'label'					=> __( 'Img width', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Default Image width for popup.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'number',
					'default'				=> 550
				],
				[
					'id' 					=> 'gpt3-defimgheight',
					'label'					=> __( 'Img height', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Default Image height for popup.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'number',
					'default'				=> 550
				],
				[
					'id' 					=> 'gpt3-scdldtfrmt',
					'label'					=> __( 'Date formate', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Set up scheduled date formate on post update metaboxes.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'text',
					'default'				=> 'M d, Y H:i'
				],
				[
					'id' 					=> 'gpt3-skipengins',
					'label'					=> __( 'Skip Engines', 'ai-content-generator-on-acf-field' ),
					'description'			=> __( 'Give here all engins IDs that you want to avoid. Should be comma seperated & without spaces.', 'ai-content-generator-on-acf-field' ),
					'type'					=> 'text',
					'default'				=> ''
				],
			]
		];
		return $args;
	}
}

/**
 * {{client_name}}, {{client_address}}, {{todays_date}}, {{retainer_amount}}
 */
