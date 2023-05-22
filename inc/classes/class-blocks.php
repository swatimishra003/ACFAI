<?php
/**
 * Blocks
 *
 * @package FutureWordPressProjectAIContentGenerator
 */

namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc;

use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;

class Blocks {
	use Singleton;

	protected function __construct() {

		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		add_filter( 'block_categories_all', [ $this, 'add_block_categories' ] );
	}

	/**
	 * Add a block category
	 *
	 * @param array $categories Block categories.
	 *
	 * @return array
	 */
	public function add_block_categories( $categories ) {

		$category_slugs = wp_list_pluck( $categories, 'slug' );

		return in_array( 'ai-content-generator-on-acf-field', $category_slugs, true ) ? $categories : array_merge(
			$categories,
			[
				[
					'slug'  => 'ai-content-generator-on-acf-field',
					'title' => __( 'Aquila Blocks', 'ai-content-generator-on-acf-field' ),
					'icon'  => 'table-row-after',
				],
			]
		);

	}

}
