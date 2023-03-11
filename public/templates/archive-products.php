<?php
/**
 * The public-facing product archive file of the plugin.
 *
 * @link       https://#
 * @since      1.0.0
 *
 * @package    Computan_Test
 * @subpackage Computan_Test/public/templates/archive-products.php
 */

get_header();
?>
	<div class="container my-5">
		<div class="row mb-4">
			<form class="row align-items-center" action="<?php esc_attr_e( esc_url( home_url( '/' ) ) ); ?>" method="get">
				<div class="col-md-4 mb-3">
					<label for="brand" class="form-label">Brand</label>
					<select name="brand" id="brand" class="form-select">
						<option value="">All Brands</option>
						<?php
						$brands = get_terms(
							array(
								'taxonomy'   => 'brand',
								'hide_empty' => true,
							)
						);
						foreach ( $brands as $brand ) {
							printf(
								'<option value="%1$s" %2$s>%3$s</option>',
								esc_attr( $brand->slug ),
								selected( $brand->slug, get_query_var( 'brand' ), false ),
								esc_html( $brand->name )
							);
						}
						?>
					</select>
				</div>
				<div class="col-md-4 mb-3">
					<label for="category" class="form-label">Category</label>
					<select name="category" id="category" class="form-select">
						<option value="">All Categories</option>
						<?php
						$categories = get_terms(
							array(
								'taxonomy'   => 'category',
								'hide_empty' => true,
							)
						);
						foreach ( $categories as $category ) {
							printf(
								'<option value="%1$s" %2$s>%3$s</option>',
								esc_attr( $category->slug ),
								selected( $category->slug, get_query_var( 'category' ), false ),
								esc_html( $category->name )
							);
						}
						?>
					</select>
				</div>
				<div class="col-md-4" style="margin-top: 1rem;">
					<button type="submit" class="col-md-4 btn btn-primary">Filter</button>
				</div>
			</form>
		</div>
	</div>

	<div class="container">
		<div class="row mx-0">
			<?php
			$cpage = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
			$args  = array(
				'post_type'      => 'products',
				'posts_per_page' => 12,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'paged'          => $cpage,

			);
			$products = new WP_Query( $args );
			if ( $products->have_posts() ) :
				while ( $products->have_posts() ) :
					$products->the_post();
					$posts_id      = get_the_ID();
					$post_title    = get_the_title();
					$post_content  = get_the_content();
					$post_price    = get_post_meta( $posts_id, 'product_price', true );
					$post_discount = get_post_meta( $posts_id, 'product_discount', true );
					$post_rating   = get_post_meta( $posts_id, 'product_rating', true );
					$post_stock    = get_post_meta( $posts_id, 'product_stock', true );
					$category      = get_the_terms( $posts_id, 'category' );
					$brand         = get_the_terms( $posts_id, 'brand' );
					?>
					<div class="col-md-4 mb-3">
						<div class="card">
                            <?php
                            if( !empty(get_the_post_thumbnail_url( $posts_id ))){
                                ?>
							    <img src="<?php esc_attr_e( get_the_post_thumbnail_url( $posts_id ) ) ?>" class="card-img-top" style="height: 400px" alt="<?php esc_attr_e( $post_title ); ?>">
                                <?php
                            }
                            ?>
							<div class="card-body">
								<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php esc_attr_e( $post_title ); ?></a></h5>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">Price: <?php esc_attr_e( $post_price ); ?></li>
									<li class="list-group-item">Category:
                                        <?php
                                            $count = 1;
                                            if(count($category) >= 1)
                                            foreach($category as $single){
                                                esc_attr_e( $single->name );
                                                (count($category) > $count) ? esc_attr_e (', ') : '';
                                                $count++;
                                            }
                                        ?>
                                    </li>
                                    <li class="list-group-item">Brand:
                                        <?php
                                            $count = 1;
                                            if(count($brand) >= 1)
                                            foreach($brand as $single){
                                                esc_attr_e( $single->name );
                                                (count($brand) > $count) ? esc_attr_e (', ') : '';
                                                $count++;
                                            }
                                        ?>
                                    </li>
								</ul>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				$pagination = paginate_links(
					array(
						'base'      => add_query_arg( 'page', '%#%' ),
						'format'    => '',
						'current'   => $cpage,
						'total'     => $products->max_num_pages,
						'prev_next' => true,
                        'prev_text' => '<span class="prev-link page-link">Previous</span>',
                        'next_text' => '<span class="next-link page-link">Next</span>',
                        'before_page_number' => '<span class="page-number page-link">',
                        'after_page_number' => '</span>',
					)
				);
				wp_reset_postdata();
			endif;
			?>
		</div>
        <div class="row mx-0 px-3">
            <?php
            if ( $pagination ) {
                ?>
                <div class="pagination pagination d-flex align-items-center justify-content-center">
                    <?php
                    echo $pagination;
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
	</div>
<?php
get_footer();
