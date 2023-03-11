<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://#
 * @since      1.0.0
 *
 * @package    Computan_Test
 * @subpackage Computan_Test/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Computan_Test
 * @subpackage Computan_Test/admin
 * @author     Sahib Bilal <itsbilalmahmood@gmail.com>
 */
class Computan_Test_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Computan_Test_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Computan_Test_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/computan-test-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Computan_Test_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Computan_Test_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/computan-test-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_media();
	}

	/**
	 * Register CPT for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_cpt_and_taxonomies() {
		$labels = array(
			'name'               => 'Products',
			'singular_name'      => 'Product',
			'add_new_item'       => 'Add New Product',
			'edit_item'          => 'Edit Product',
			'new_item'           => 'New Product',
			'view_item'          => 'View Product',
			'search_items'       => 'Search Products',
			'not_found'          => 'No products found',
			'not_found_in_trash' => 'No products found in trash',
			'menu_name'          => 'Products',
		);
		$args   = array(

			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
			'taxonomies'          => array( 'genres' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-cart',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'rewrite'             => array( 'slug' => 'products' ),
		);
		register_post_type( 'products', $args );

		$category_labels = array(
			'name'          => 'Product Categories',
			'singular_name' => 'Product Category',
			'search_items'  => 'Search Product Categories',
			'all_items'     => 'All Product Categories',
			'edit_item'     => 'Edit Product Category',
			'update_item'   => 'Update Product Category',
			'add_new_item'  => 'Add New Product Category',
			'new_item_name' => 'New Product Category Name',
			'menu_name'     => 'Categories',
		);
		$category_args   = array(
			'show_ui'               => true,
			'show_in_rest'          => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'labels'                => $category_labels,
			'hierarchical'          => true,
			'rewrite'               => array( 'slug' => 'category' ),
		);
		register_taxonomy( 'category', 'products', $category_args );

		$brand_labels = array(
			'name'          => 'Product Brands',
			'singular_name' => 'Product Brand',
			'search_items'  => 'Search Product Brands',
			'all_items'     => 'All Product Brands',
			'edit_item'     => 'Edit Product Brand',
			'update_item'   => 'Update Product Brand',
			'add_new_item'  => 'Add New Product Brand',
			'new_item_name' => 'New Product Brand Name',
			'menu_name'     => 'Brands',
		);
		$brand_args   = array(
			'show_ui'               => true,
			'show_in_rest'          => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'labels'                => $brand_labels,
			'hierarchical'          => true,
			'rewrite'               => array( 'slug' => 'brand' ),
		);
		register_taxonomy( 'brand', 'products', $brand_args );
	}

	/**
	 * Add custom fields in CPT name products.
	 *
	 * @param      string $post       The post of ctp.
	 * @since    1.0.0
	 */
	public function add_meta_boxes_products_function( $post ) {
		add_meta_box( 'product_api', __( 'API ID', 'computan-test' ), array( $this, 'product_api_details' ), 'products', 'normal', 'low' );
		add_meta_box( 'product_price', __( 'Price', 'computan-test' ), array( $this, 'product_price_details' ), 'products', 'normal', 'low' );
		add_meta_box( 'product_discount', __( 'Discount Percentage', 'computan-test' ), array( $this, 'product_discount_details' ), 'products', 'normal', 'low' );
		add_meta_box( 'product_rating', __( 'Rating', 'computan-test' ), array( $this, 'product_rating_details' ), 'products', 'normal', 'low' );
		add_meta_box( 'product_stock', __( 'Stock', 'computan-test' ), array( $this, 'product_stock_details' ), 'products', 'normal', 'low' );

	}

	/**
	 * Custom field sku details in CPT name products.
	 *
	 * @param      string $post       The post of ctp.
	 * @since    1.0.0
	 */
	public function product_api_details( $post ) {
		$nonce = wp_create_nonce( 'form_nonce' );
		?>
		<p>
			<input type="hidden" name="form_nonce" value="<?php echo esc_attr( $nonce ); ?>" />
			<input type="text" name="product_api" value="<?php esc_attr_e( get_post_meta( $post->ID, 'product_api', true ) ); ?>"  style="width: 100%;"/>
		</p>
		<?php
	}

	/**
	 * Custom field price details in CPT name products.
	 *
	 * @param      string $post       The post of ctp.
	 * @since    1.0.0
	 */
	public function product_price_details( $post ) {
		?>
		<p>
			<input type="number" name="product_price" value="<?php esc_attr_e( get_post_meta( $post->ID, 'product_price', true ) ); ?>"  style="width: 100%;"/>
		</p>
		<?php
	}

	/**
	 * Custom field price details in CPT name products.
	 *
	 * @param      string $post       The post of ctp.
	 * @since    1.0.0
	 */
	public function product_discount_details( $post ) {
		?>
		<p>
			<input type="number" name="product_discount" value="<?php esc_attr_e( get_post_meta( $post->ID, 'product_discount', true ) ); ?>"  style="width: 100%;"/>
		</p>
		<?php
	}

	/**
	 * Custom field rating details in CPT name products.
	 *
	 * @param      string $post       The post of ctp.
	 * @since    1.0.0
	 */
	public function product_rating_details( $post ) {
		?>
		<p>
			<input type="number" name="product_rating" value="<?php esc_attr_e( get_post_meta( $post->ID, 'product_rating', true ) ); ?>"  style="width: 100%;"/>
		</p>
		<?php
	}

	/**
	 * Custom field Stock in CPT name products.
	 *
	 * @param      string $post       The post of ctp.
	 * @since    1.0.0
	 */
	public function product_stock_details( $post ) {
		?>
		<p>
			<input type="number" name="product_stock" value="<?php esc_attr_e( get_post_meta( $post->ID, 'product_stock', true ) ); ?>"  style="width: 100%;"/>
		</p>
		<?php
	}

	/**
	 * Save custom field details.
	 *
	 * @param      string $post_id       The post of ctp.
	 * @since    1.0.0
	 */
	public function save_post_function( $post_id ) {
		if ( isset( $_POST['form_nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['form_nonce'] ) );
			if ( wp_verify_nonce( $nonce, 'form_nonce' ) ) {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
				if ( isset( $_POST['product_api'] ) ) {
					update_post_meta( $post_id, 'product_api', sanitize_text_field( wp_unslash( $_POST['product_api'] ) ) );
				}
				if ( isset( $_POST['product_price'] ) ) {
					update_post_meta( $post_id, 'product_price', sanitize_text_field( wp_unslash( $_POST['product_price'] ) ) );
				}
				if ( isset( $_POST['product_discount'] ) ) {
					update_post_meta( $post_id, 'product_discount', sanitize_text_field( wp_unslash( $_POST['product_discount'] ) ) );
				}
				if ( isset( $_POST['product_rating'] ) ) {
					update_post_meta( $post_id, 'product_rating', sanitize_text_field( wp_unslash( $_POST['product_rating'] ) ) );
				}
				if ( isset( $_POST['product_stock'] ) ) {
					update_post_meta( $post_id, 'product_stock', sanitize_text_field( wp_unslash( $_POST['product_stock'] ) ) );
				}
			}
		}
	}

	/**
	 * Import product from API after plugin installation.
	 *
	 * @since    1.0.0
	 */
	public function trigger_cron_job_import_products() {
		$response = wp_remote_get( 'https://dummyjson.com/products' );
		if ( is_wp_error( $response ) ) {
			return;
		}
		$products = json_decode( wp_remote_retrieve_body( $response ), true );
		foreach ( $products['products'] as $single ) {
			$api_id        = $single['id'];
			$post_title    = $single['title'];
			$post_content  = $single['description'];
			$post_price    = $single['price'];
			$post_discount = $single['discountPercentage'];
			$post_rating   = $single['rating'];
			$post_stock    = $single['stock'];
			$post_status   = 'publish';
			$post_data     = array(
				'post_title'   => $post_title,
				'post_content' => $post_content,
				'post_status'  => $post_status,
				'post_type'    => 'products',
				'post_author'  => 1,
			);
			$post          = get_page_by_title( $post_title, OBJECT, 'products' );
			if ( ! $post ) {
				$post_id = wp_insert_post( $post_data );
				if ( $post_id ) {
					$image_size = wp_remote_get( $single['thumbnail'] );
					if ( ! empty( $image_size ) ) {
						$attach_id = $this->upload_product_images( $single['thumbnail'], $post_id );
						set_post_thumbnail( $post_id, $attach_id );
					}
					update_post_meta( $post_id, 'product_api', $api_id );
					update_post_meta( $post_id, 'product_price', $post_price );
					update_post_meta( $post_id, 'product_discount', $post_discount );
					update_post_meta( $post_id, 'product_rating', $post_rating );
					update_post_meta( $post_id, 'product_stock', $post_stock );

					if ( ! empty( $single['category'] ) ) {
						$term_exists = term_exists( $single['category'], 'category' );
						if ( $term_exists ) {
							wp_set_object_terms( $post_id, $single['category'], 'category', true );
						} else {
							$term_data = wp_insert_term( $single['category'], 'category' );
							if ( ! is_wp_error( $term_data ) ) {
								wp_set_object_terms( $post_id, $single['category'], 'category', true );
							}
						}
					}
					if ( ! empty( $single['brand'] ) ) {
						$term_exists = term_exists( $single['brand'], 'brand' );
						if ( $term_exists ) {
							wp_set_object_terms( $post_id, $single['brand'], 'brand', true );
						} else {
							$term_data = wp_insert_term( $single['brand'], 'brand' );
							if ( ! is_wp_error( $term_data ) ) {
								wp_set_object_terms( $post_id, $single['brand'], 'brand', true );
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Upload media and return media id.
	 *
	 * @param      string $image_url       The image url for post.
	 * @param      string $post_id       The post id for post.
	 * @since    1.0.0
	 */
	public function upload_product_images( $image_url, $post_id ) {
		$image_name       = basename( $image_url );
		$upload_dir       = wp_upload_dir();
		$image_data       = file_get_contents( $image_url );
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name );
		$filename         = $upload_dir['path'] . '/' . $unique_file_name;
		file_put_contents( $filename, $image_data );
		$file_type        = wp_check_filetype( $filename, null );
		$attachment_title = sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) );
		$wp_upload_dir    = wp_upload_dir();
		$attachment       = array(
			'guid'           => $wp_upload_dir['url'] . '/' . $unique_file_name,
			'post_mime_type' => $file_type['type'],
			'post_title'     => $attachment_title,
			'post_content'   => '',
			'post_status'    => 'inherit',
		);
		return wp_insert_attachment( $attachment, $filename, $post_id );
	}
}
