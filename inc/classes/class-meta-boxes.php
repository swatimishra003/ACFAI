<?php
/**
 * Register Meta Boxes
 *
 * @package FutureWordPressProjectAIContentGenerator
 */
namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc;
use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;
/**
 * Class Meta_Boxes
 */
class Meta_Boxes {
	use Singleton;
	protected function __construct() {
		// load class.
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		/**
		 * Actions.
		 */
		add_action( 'add_meta_boxes', [ $this, 'add_custom_meta_box' ] );
		add_action( 'save_post', [ $this, 'save_post_meta_data' ] );
		add_action( 'post_submitbox_misc_actions', [ $this, 'post_submitbox_misc_actions' ], 10, 1 );
		add_action( 'save_post', [ $this, 'schedule_post_based_on_meta' ] );
		add_action( 'publish_scheduled_aigpt3_post', [ $this, 'publish_scheduled_aigpt3_post' ] );
		add_filter( 'wp_insert_post_data', [ $this, 'wp_insert_post_data' ], 10, 2 );
	}
	/**
	 * Add custom meta box.
	 *
	 * @return void
	 */
	public function add_custom_meta_box() {
		$screens = explode( ',', str_replace( ' ', '', apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-screens', '' ) ) );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'acfgpt3_metabox_editscreen',           				// Unique ID
				__( 'Generate Content', 'ai-content-generator-on-acf-field' ),  // Box title
				[ $this, 'custom_meta_box_html' ],  		// Content callback, must be of type callable
				$screen,                   							// Post type
				'side'                   								// context
			);
		}
	}
	/**
	 * Custom meta box HTML( for form )
	 *
	 * @param object $post Post.
	 *
	 * @return void
	 */
	public function custom_meta_box_html( $post ) {
		$meta = (array) get_post_meta( $post->ID, 'checkout_video_clip', true );
		$shortHand = site_url( '/clip/' . dechex( $post->ID ) );
		$shortned = str_replace( [ 'https://www.', 'http://www.' ], [ '', '' ], $shortHand );
		?>
		<button class="acfgpt3-openpopup button btn">Generate Content</button>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<?php
	}
	/**
	 * Save post meta into database
	 * when the post is saved.
	 *
	 * @param integer $post_id Post id.
	 *
	 * @return void
	 */
	public function save_post_meta_data( $post_id ) {
		/**
		 * When the post is saved or updated we get $_POST available
		 * Check if the current user is authorized
		 */
		if( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if( array_key_exists( 'aigpt3_scheduled_on', $_POST ) ) {
			$current_time = current_time('timestamp');
			$scheduled_time = strtotime( $_POST['aigpt3_scheduled_on'] );
			if( $scheduled_time > $current_time ) {
				update_post_meta( $post_id, 'aigpt3_scheduled_on', sanitize_text_field( $_POST['aigpt3_scheduled_on'] ) );
			} else {
				if( metadata_exists( 'post', $post_id, 'aigpt3_scheduled_on' ) ) {
					delete_post_meta( $post_id, 'aigpt3_scheduled_on' );
				}
			}
		}
	}

	public function post_submitbox_misc_actions( $post ) {
		// if( ! in_array( $post->pagenow, [ 'post.php', 'post-new.php' ], true ) ) {return;}
		$sat_scheduled = get_post_meta( $post->ID, 'aigpt3_scheduled_on', true );
		$availability = ( strtotime( $sat_scheduled ) > time() );
		$sat_scheduled = ( ! $sat_scheduled || empty( $sat_scheduled ) ) ? (
			$availability ? date( 'M d, Y H:i' ) : false
		) : $sat_scheduled;
		?>
			<div id="aigpt3-acf-field-submitbox">
				<span class="dashicons-before dashicons-clock" aria-hidden="true"></span>
				<span class="score-text">
					<a href="javascript:void(0)"><?php esc_html_e( 'Schedule', 'ai-content-generator-on-acf-field' ); ?></a>: <strong><?php echo esc_html(
						( ! $sat_scheduled || empty( $sat_scheduled ) ) ? __( 'Not available', 'ai-content-generator-on-acf-field' ) : wp_date( apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'gpt3-scdldtfrmt', 'M d, Y H:i' ), strtotime( $sat_scheduled ) )
					); ?></strong>
					<input type="text" name="aigpt3_scheduled_on" id="aigpt3_scheduled_on" value="<?php echo esc_attr( $availability ? date( 'c', strtotime( $sat_scheduled ) ) : '' ); ?>">
					<!-- Y-M-d H:i -->
				</span>
			</div>
		<?php
	}
	public function schedule_post_based_on_meta( $post_id ) {
		$scheduled_on = get_post_meta( $post_id, '_scheduled_on', true );
		if( empty( $scheduled_on ) || ! strtotime( $scheduled_on ) ) {
		  return;
		}
		$current_time = current_time('timestamp');
		$scheduled_time = strtotime( $scheduled_on );
		if( $scheduled_time > $current_time ) {
		  $time_diff = $scheduled_time - $current_time;
		  wp_schedule_single_event( time() + $time_diff, 'publish_scheduled_aigpt3_post', [$post_id] );
		}
	}
	public function publish_scheduled_aigpt3_post( $post_id ) {
		wp_update_post( [
			'ID'          => $post_id,
			'post_status' => 'publish'
		] );
		set_transient( 'futurewordpress/project/aicontentgenerator/transiant/admin/' . get_post_field( 'post_author', $post_id ), [
			'type'			=> 'info','title' => __( 'One post has been published.', 'ai-content-generator-on-acf-field' ),
			'message'		=> sprintf( __( '"%s" has been updated on %s autometically.', 'ai-content-generator-on-acf-field' ), get_the_title( $post_id ), date( 'M d, Y H:i:s', $scheduled_time ) )
		], 12000 );
	}
	public function wp_insert_post_data( $data, $postarr ) {
		// wp_send_json_error( [$data, $postarr] );wp_die();
		if( $data['post_status'] === 'publish' && isset( $_POST['aigpt3_scheduled_on'] ) ) {
			// $post_id = isset( $postarr['ID'] ) ? $postarr['ID'] : false;
			$scheduled_on = $_POST['aigpt3_scheduled_on']; // get_post_meta( $post_id, 'aigpt3_scheduled_on', true );
			if( empty( $scheduled_on) || !strtotime( $scheduled_on ) ) {
				return $data;
			}
			$current_time = current_time('timestamp');
			$scheduled_time = strtotime( $scheduled_on);
			if( $scheduled_time > $current_time ) {
				$data['post_status'] = 'draft';
				set_transient( 'futurewordpress/project/aicontentgenerator/transiant/admin/' . get_current_user_id(), [
					'type'			=> 'info','title' => __( 'Awaiting the Perfect Moment.', 'ai-content-generator-on-acf-field' ),
					'message'		=> sprintf( __( 'This post has been scheduled for a future date and cannot be published until %s.', 'ai-content-generator-on-acf-field' ), date( 'M d, Y H:i:s', $scheduled_time ) )
				], 300 );
			}
		}
		return $data;
	}
}
