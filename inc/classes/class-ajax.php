<?php
/**
 * Block Patterns
 *
 * @package FutureWordPressProjectAIContentGenerator
 */

namespace FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc;

use FUTUREWORDPRESS_PROJECT_AICONTENTGENERATOR\Inc\Traits\Singleton;

class Ajax {
	use Singleton;
	protected function __construct() {
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		// add_action( 'wp_ajax_futurewordpress/project/aicontentgenerator/action/test', [ $this, 'testAjax' ], 10, 0 );
		add_action( 'wp_ajax_futurewordpress/project/aicontentgenerator/upload/medias', [ $this, 'import2Media' ], 10, 0 );
	}
	public function testAjax() {
		wp_send_json_success( [ 'message' => 'some text', 'hooks' => ['fuck'] ], 200 );
	}
	public function import2Media() {
		$post_id = isset( $_POST[ 'post_id' ] ) ? $_POST[ 'post_id' ] : false;
		$return_json = [
			'message' => 'Successful',
			'images' => [],
			'hooks' => [ 'insertInToGallery' ]
		];
		$data = (object) wp_parse_args( $_POST, [
			'images'		=> '',
			'importImages'	=> true,
			'toGallery'		=> false,
			'toPostType'	=> false,
		] );
		
		$selectedImages = (array) explode( ',', (string) $data->images );
		// Retrieve the default WordPress upload directory path
		$uploadDir = wp_upload_dir();
		// Ensure the directory exists and is writable
		if( ! is_writable( $uploadDir[ 'path' ] ) ) {
			wp_send_json_error( __( 'Unable to write to the upload directory.', 'ai-content-generator-on-acf-field' ) );
		}

		$uploadedImageIds = [];

		if( $data->importImages ) {
			foreach ($selectedImages as $imageUrl) {
				$imageData = file_get_contents($imageUrl);
				// Generate a unique filename for the image
				$filename = uniqid() . '.jpg';
				$filePath = $uploadDir['path'] . '/' . $filename;
				// Save the image to the uploads directory
				file_put_contents($filePath, $imageData);
				// Attach the image to WordPress media library
				$attachment = [
					'post_title' => $filename,
					'post_content' => '',
					'post_status' => 'inherit',
					'post_mime_type' => 'image/jpeg'
				];
				$attachmentId = wp_insert_attachment( $attachment, $filePath );
				$uploadedImageIds[] = $attachmentId;
				$return_json[ 'images' ][] = [
					'id'	=> $attachmentId,
					'url'	=> str_replace( ABSPATH, site_url( '/' ), $filePath )
				];
			}
		}
		if( $data->toGallery && $post_id && false ) {
			if( metadata_exists( 'post', $post_id, '_gallery_images' ) ) {
				update_post_meta( $post_id, '_gallery_images', $data->toGallery );
				update_post_meta( $post_id, 'gallery_images', $uploadedImageIds );
			} else {
				// $galleryData = [
				// 	'post_title' => 'Gallery',
				// 	'post_content' => '',
				// 	'post_status' => 'publish',
				// 	'post_type' => $data->toPostType, // Replace with your custom post type
				// 	'meta_input' => [
				// 		'_gallery_images' => $data->toGallery,
				// 		'gallery_images' => $uploadedImageIds
				// 	]
				// ];
				// $galleryId = wp_insert_post( $galleryData );
			}
		}

		$return_json[ 'imgids' ] = $uploadedImageIds;
		$return_json[ 'message' ] = __( 'Successfully imported into media library.', 'ai-content-generator-on-acf-field' );
		wp_send_json_success( $return_json, 200 );
	}
}
