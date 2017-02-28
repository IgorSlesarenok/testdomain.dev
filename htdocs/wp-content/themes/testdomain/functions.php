<?php

/**
 * Register Footer "Contact Us" widget area.
 */
 
	register_sidebar( array(
		'name'          => __( 'Contact Us in Footer', 'twentyseventeen' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'Add widgets here to appear in your footer Contact Us area.', 'twentyseventeen' ),
		'before_widget' => '<div id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="contactus-footer-title">',
		'after_title'   => '</div>',
	) );

	/**
 * Product Summary Box.
 *
 * @see woocommerce_template_single_title()
 * @see woocommerce_template_single_rating()
 * @see woocommerce_template_single_price()
 * @see woocommerce_template_single_excerpt()
 * @see woocommerce_template_single_meta()
 * @see woocommerce_template_single_sharing()
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 30 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 50 );


/**
 * Adding the Custom Post type "Books".
 */
register_post_type('books',
    array(
        'labels' => array(
            'name' => __('Books'),
            'singular_name' => __('Book'),
             'add_new' => 'Add New',
             'add_new_item' => 'Add New Book',
             'edit' => 'Edit',
             'edit_item' => 'Edit Book',
             'new_item' => 'New Book',
             'view' => 'View',
             'view_item' => 'View Book',
             'search_items' => 'Search Book',
             'not_found' => 'No Books found',
             'not_found_in_trash' => 'No Books found in Trash',
             'parent' => 'Parent Book'
        ),
        'public' => true,
        'publicly_queryable' => true,
        'query_var' => true,
		'menu_position' => 4,
        'taxonomies' => array('genre'),
        'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
        'rewrite' => array('slug' => 'books'),

    )
);

/**
 * Adding taxonomy "Genre".
 */
add_action('init', 'create_taxonomy');
function create_taxonomy(){
	$labels = array(
		'name'              => 'Genre',
		'singular_name'     => 'Genre',
		'search_items'      => 'Search Genres',
		'all_items'         => 'All Genres',
		'parent_item'       => 'Parent Genre',
		'parent_item_colon' => 'Parent Genre:',
		'edit_item'         => 'Edit Genre',
		'update_item'       => 'Update Genre',
		'add_new_item'      => 'Add New Genre',
		'new_item_name'     => 'New Genre Name',
		'menu_name'         => 'Genre',
	); 
	$args = array(
		'label'                 => '', 
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null, 
		'show_in_nav_menus'     => true, 
		'show_ui'               => true, 
		'show_tagcloud'         => false, 
		'show_in_rest'          => null, 
		'rest_base'             => null, 
		'hierarchical'          => false,
		'update_count_callback' => '',
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null, 
		'show_admin_column'     => true, 
		'_builtin'              => false,
		'show_in_quick_edit'    => null, 
	);
	register_taxonomy('taxonomy', array('books'), $args );
}

/**
 * Create a template for Single Book.
 */
add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
    if ( get_post_type() == 'books' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'single-book.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . 'single-book.php';
            }
        }
    }
    return $template_path;
}


add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'books',
		array(
			'labels' => array(
				'name' => __( 'Books' ),
				'singular_name' => __( 'Books' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}