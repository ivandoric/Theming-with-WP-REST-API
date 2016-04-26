<?php

/*  Register Scripts and Style */

function theme_register_scripts() {
    wp_enqueue_style( 'olympos-css', get_stylesheet_uri() );
    wp_enqueue_script( 'olympos-js', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/olympos.min.js' ), array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'theme_register_scripts', 1 );


/* Add menu support */
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
}

/* Add post image support */
add_theme_support( 'post-thumbnails' );


/* Add custom thumbnail sizes */
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( '300x180', 300, 180, true );
}

/* Add widget support */
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'SidebarOne',
	    'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));
    
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'SidebarTwo',
	    'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));


/*  EXCERPT 
    Usage:
    
    <?php echo excerpt(100); ?>
*/

function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
    } else {
    $excerpt = implode(" ",$excerpt);
    } 
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

/*
|--------------------------------------------------------------------------
| Prepare REST
|--------------------------------------------------------------------------
*/

function prepare_rest($data, $post, $request){
    $_data = $data->data;

    // Thumbnails
    $thumbnail_id = get_post_thumbnail_id( $post->ID );
    $thumbnail300x180 = wp_get_attachment_image_src( $thumbnail_id, '300x180' );
    $thumbnailMedium = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
    $full = wp_get_attachment_image_src( $thumbnail_id, 'full' );

    //Categories
    $cats = get_the_category($post->ID);

    //next/prev
    
    $nextPost = get_adjacent_post(false, '', true );
    $nextPost = $nextPost->ID;

    $prevPost = get_adjacent_post(false, '', false );
    $prevPost = $prevPost->ID;

    $_data['fi_300x180'] = $thumbnail300x180[0];
    $_data['fi_medium'] = $thumbnailMedium[0];
    $_data['full'] = $full[0];
    $_data['cats'] = $cats;
    $_data['next_post'] = $nextPost;
    $_data['previous_post'] = $prevPost;
    $data->data = $_data;

    return $data;
}
add_filter('rest_prepare_post', 'prepare_rest', 10, 3);

add_action('rest_api_init', 'register_custom_fields', 1, 1);

function register_custom_fields(){
    register_rest_field(
        'movies',
        'year',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'movies',
        'director',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'movies',
        'thumbnail',
        array(
            'get_callback' => 'show_image'
        )
    );    
}

function show_fields($object, $field_name, $request){
    $field_name = 'wpcf-' . $field_name;
    return get_post_meta($object['id'], $field_name, true);
}

function show_image($object, $field_name, $request){
    $thumbID = get_post_thumbnail_id($object['id']);
    $image = wp_get_attachment_image_src( $thumbID, '300x180');
    return $image[0];
}




