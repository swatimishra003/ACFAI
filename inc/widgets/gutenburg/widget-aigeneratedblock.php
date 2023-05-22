<?php
/**
 * Elementor widget for youtube playlist displaying
 *
 * @category	Litivo Listing Site
 * @package FutureWordPressProjectAIContentGenerator
 * @author		FutureWordPress.com <info@futurewordpress.com/>
 * @copyright	Copyright (c) 2022-23
 * @link		https://futurewordpress.com/
 * @version		1.3.6
 */
namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Widgets;
if( ! defined( 'ABSPATH' ) ) {exit;} // Exit if accessed directly.


use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;

class AIGeneratedBlock extends \WP_Widget {

    public function __construct() {
        parent::__construct(
            'ai-generated-block',
            'AI Generated Block',
            [
				'description' => 'AI Generated Block contents'
			]
        );
    }

    // Widget frontend display
    public function widget($args, $instance) {
        // Widget output code
        echo '
			<div>
				<p>' . $instance[ 'content' ] . '</p>
			</div>
		';
    }

    // Widget backend form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $content = !empty($instance['content']) ? $instance['content'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('content'); ?>"><?php esc_html_e( 'Content:', 'ai-content-generator-on-acf-field' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo esc_textarea($content); ?></textarea>
        </p>
        <?php
    }

    // Widget update
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['content'] = (!empty($new_instance['content'])) ? sanitize_text_field($new_instance['content']) : '';
        return $instance;
    }
}