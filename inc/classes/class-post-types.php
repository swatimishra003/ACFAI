<?php
/**
 * Register Post Types
 *
 * @package FutureWordPressProjectAIContentGenerator
 */

namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc;

use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;
 
class PostTypes {
	use Singleton;

	protected function __construct() {

		// load class.
		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		add_action( 'init', [ $this, 'create_movie_cpt' ], 0 );

	}

	// Register Custom Post Type Movie
	public function create_movie_cpt() {

		$labels = [
			'name'                  => _x( 'Movies', 'Post Type General Name', 'ai-content-generator-on-acf-field' ),
			'singular_name'         => _x( 'Movie', 'Post Type Singular Name', 'ai-content-generator-on-acf-field' ),
			'menu_name'             => _x( 'Movies', 'Admin Menu text', 'ai-content-generator-on-acf-field' ),
			'name_admin_bar'        => _x( 'Movie', 'Add New on Toolbar', 'ai-content-generator-on-acf-field' ),
			'archives'              => __( 'Movie Archives', 'ai-content-generator-on-acf-field' ),
			'attributes'            => __( 'Movie Attributes', 'ai-content-generator-on-acf-field' ),
			'parent_item_colon'     => __( 'Parent Movie:', 'ai-content-generator-on-acf-field' ),
			'all_items'             => __( 'All Movies', 'ai-content-generator-on-acf-field' ),
			'add_new_item'          => __( 'Add New Movie', 'ai-content-generator-on-acf-field' ),
			'add_new'               => __( 'Add New', 'ai-content-generator-on-acf-field' ),
			'new_item'              => __( 'New Movie', 'ai-content-generator-on-acf-field' ),
			'edit_item'             => __( 'Edit Movie', 'ai-content-generator-on-acf-field' ),
			'update_item'           => __( 'Update Movie', 'ai-content-generator-on-acf-field' ),
			'view_item'             => __( 'View Movie', 'ai-content-generator-on-acf-field' ),
			'view_items'            => __( 'View Movies', 'ai-content-generator-on-acf-field' ),
			'search_items'          => __( 'Search Movie', 'ai-content-generator-on-acf-field' ),
			'not_found'             => __( 'Not found', 'ai-content-generator-on-acf-field' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'ai-content-generator-on-acf-field' ),
			'featured_image'        => __( 'Featured Image', 'ai-content-generator-on-acf-field' ),
			'set_featured_image'    => __( 'Set featured image', 'ai-content-generator-on-acf-field' ),
			'remove_featured_image' => __( 'Remove featured image', 'ai-content-generator-on-acf-field' ),
			'use_featured_image'    => __( 'Use as featured image', 'ai-content-generator-on-acf-field' ),
			'insert_into_item'      => __( 'Insert into Movie', 'ai-content-generator-on-acf-field' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Movie', 'ai-content-generator-on-acf-field' ),
			'items_list'            => __( 'Movies list', 'ai-content-generator-on-acf-field' ),
			'items_list_navigation' => __( 'Movies list navigation', 'ai-content-generator-on-acf-field' ),
			'filter_items_list'     => __( 'Filter Movies list', 'ai-content-generator-on-acf-field' ),
		];
		$args   = [
			'label'               => __( 'Movie', 'ai-content-generator-on-acf-field' ),
			'description'         => __( 'The movies', 'ai-content-generator-on-acf-field' ),
			'labels'              => $labels,
			'menu_icon'           => 'dashicons-video-alt',
			'supports'            => [
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'revisions',
				'author',
				'comments',
				'trackbacks',
				'page-attributes',
				'custom-fields',
			],
			'taxonomies'          => [],
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'hierarchical'        => false,
			'exclude_from_search' => false,
			'show_in_rest'        => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		];

		register_post_type( 'movies', $args );

	}


}
