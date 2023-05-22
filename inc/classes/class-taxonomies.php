<?php
/**
 * Register Custom Taxonomies
 *
 * @package FutureWordPressProjectAIContentGenerator
 */

namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc;

use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;

class Taxonomies {
	use Singleton;

	protected function __construct() {

		// load class.
		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		add_action( 'init', [ $this, 'create_genre_taxonomy' ] );
		add_action( 'init', [ $this, 'create_year_taxonomy' ] );

	}

	// Register Taxonomy Genre
	public function create_genre_taxonomy() {

		$labels = [
			'name'              => _x( 'Genres', 'taxonomy general name', 'ai-content-generator-on-acf-field' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'ai-content-generator-on-acf-field' ),
			'search_items'      => __( 'Search Genres', 'ai-content-generator-on-acf-field' ),
			'all_items'         => __( 'All Genres', 'ai-content-generator-on-acf-field' ),
			'parent_item'       => __( 'Parent Genre', 'ai-content-generator-on-acf-field' ),
			'parent_item_colon' => __( 'Parent Genre:', 'ai-content-generator-on-acf-field' ),
			'edit_item'         => __( 'Edit Genre', 'ai-content-generator-on-acf-field' ),
			'update_item'       => __( 'Update Genre', 'ai-content-generator-on-acf-field' ),
			'add_new_item'      => __( 'Add New Genre', 'ai-content-generator-on-acf-field' ),
			'new_item_name'     => __( 'New Genre Name', 'ai-content-generator-on-acf-field' ),
			'menu_name'         => __( 'Genre', 'ai-content-generator-on-acf-field' ),
		];
		$args   = [
			'labels'             => $labels,
			'description'        => __( 'Movie Genre', 'ai-content-generator-on-acf-field' ),
			'hierarchical'       => true,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_tagcloud'      => true,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
		];

		register_taxonomy( 'genre', [ 'movies' ], $args );

	}

	// Register Taxonomy Year
	public function create_year_taxonomy() {

		$labels = [
			'name'              => _x( 'Years', 'taxonomy general name', 'ai-content-generator-on-acf-field' ),
			'singular_name'     => _x( 'Year', 'taxonomy singular name', 'ai-content-generator-on-acf-field' ),
			'search_items'      => __( 'Search Years', 'ai-content-generator-on-acf-field' ),
			'all_items'         => __( 'All Years', 'ai-content-generator-on-acf-field' ),
			'parent_item'       => __( 'Parent Year', 'ai-content-generator-on-acf-field' ),
			'parent_item_colon' => __( 'Parent Year:', 'ai-content-generator-on-acf-field' ),
			'edit_item'         => __( 'Edit Year', 'ai-content-generator-on-acf-field' ),
			'update_item'       => __( 'Update Year', 'ai-content-generator-on-acf-field' ),
			'add_new_item'      => __( 'Add New Year', 'ai-content-generator-on-acf-field' ),
			'new_item_name'     => __( 'New Year Name', 'ai-content-generator-on-acf-field' ),
			'menu_name'         => __( 'Year', 'ai-content-generator-on-acf-field' ),
		];
		$args   = [
			'labels'             => $labels,
			'description'        => __( 'Movie Release Year', 'ai-content-generator-on-acf-field' ),
			'hierarchical'       => false,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_tagcloud'      => true,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
		];
		register_taxonomy( 'movie-year', [ 'movies' ], $args );

	}

}
