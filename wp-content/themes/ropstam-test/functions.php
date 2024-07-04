<?php
/**
 * ropstam-test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ropstam-test
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ropstam_test_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on ropstam-test, use a find and replace
		* to change 'ropstam-test' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ropstam-test', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'ropstam-test' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'ropstam_test_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ropstam_test_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ropstam_test_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ropstam_test_content_width', 640 );
}
add_action( 'after_setup_theme', 'ropstam_test_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ropstam_test_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ropstam-test' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ropstam-test' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ropstam_test_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ropstam_test_scripts() {
	wp_enqueue_style( 'ropstam-test-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'ropstam-test-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ropstam-test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue your script
	wp_enqueue_script( 'custom-ajax', get_template_directory_uri() . '/js/custom-ajax.js', array('jquery'), null, true );

	// Localize the script with the Ajax URL
	wp_localize_script( 'custom-ajax', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

}
add_action( 'wp_enqueue_scripts', 'ropstam_test_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Task 3.	Custom Post Type and Taxonomy:
 */

// Register Custom Post Type Projects
function create_projects_post_type() {
    $labels = array(
        'name'          => _x('Projects', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Project', 'Post Type Singular Name', 'text_domain'),
        'menu_name'     => __('Projects', 'text_domain'),
        'all_items'     => __('All Projects', 'text_domain'),
        'add_new_item'  => __('Add New Project', 'text_domain'),
        'edit_item'     => __('Edit Project', 'text_domain'),
        'view_item'     => __('View Project', 'text_domain'),
		
    );
    $args = array(
        'label'         => __('Project', 'text_domain'),
        'labels'        => $labels,
        'public'        => true,
        'supports'      => array('title', 'editor', 'thumbnail'),
        'has_archive'   => true,
		'rewrite'       => array('slug' => 'projects'),
        'show_in_rest'  => true,
    );
    register_post_type('projects', $args);
}
add_action('init', 'create_projects_post_type', 0);

// Register Custom Taxonomy Project Type
function create_project_type_taxonomy() {
    $labels = array(
        'name'          => _x('Project Types', 'Taxonomy General Name', 'text_domain'),
        'singular_name' => _x('Project Type', 'Taxonomy Singular Name', 'text_domain'),
        'menu_name'     => __('Project Type', 'text_domain'),
        'all_items'     => __('All Project Types', 'text_domain'),
        'edit_item'     => __('Edit Project Type', 'text_domain'),
        'view_item'     => __('View Project Type', 'text_domain'),
        'add_new_item'  => __('Add New Project Type', 'text_domain'),
    );
    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'hierarchical'  => true,
        'show_in_rest'  => true,
    );
    register_taxonomy('project_type', array('projects'), $args);
}
add_action('init', 'create_project_type_taxonomy', 0);


/**
 * Task 5.	Ajax Endpoint:
 */

// Add Ajax endpoint for fetching projects
add_action( 'wp_ajax_nopriv_get_architecture_projects', 'get_architecture_projects_callback' );
add_action( 'wp_ajax_get_architecture_projects', 'get_architecture_projects_callback' );

function get_architecture_projects_callback() {
    // Check if user is logged in
    $is_logged_in = is_user_logged_in();
    
    $args = array(
        'post_type'      => 'projects',
        'posts_per_page' => $is_logged_in ? 6 : 3,
        'tax_query'      => array(
            array(
                'taxonomy' => 'project_type',
                'field'    => 'slug',
                'terms'    => 'architecture',
            ),
        ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $projects_query = new WP_Query( $args );
    
    $projects = array();
    if ( $projects_query->have_posts() ) {
        while ( $projects_query->have_posts() ) {
            $projects_query->the_post();
            $projects[] = array(
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'link'  => get_permalink(),
            );
        }
        wp_reset_postdata();
    }
    
    // Return JSON response
    wp_send_json_success( array(
        'success' => true,
        'data'    => $projects,
    ) );
    
    wp_die();
}

/**
 * Task 6.	Random Coffee API Integration:
 */

function hs_give_me_coffee() {
    // Endpoint URL for the Random Coffee API
    $url = 'https://coffee.alexflipnote.dev/random.json';

    $response = wp_remote_get( $url );

    // Check if the request was successful
    if ( is_wp_error( $response ) ) {
        return false; 
    }

    // Retrieve the body of the response
    $body = wp_remote_retrieve_body( $response );

    // Decode JSON data
    $data = json_decode( $body );

    // Check if JSON decoding was successful
    if ( ! $data ) {
        return false;
    }

    // Get the direct link to the coffee image
    $coffee_link = isset( $data->file ) ? $data->file : '';

	echo "<img src='" . $coffee_link . "'>";
	
	
}
add_action('wp_body_open', 'hs_give_me_coffee');


/**
 * Task 7.	Kanye Quotes Page:
 */

function get_quotes() {

	for ($i = 0; $i < 5; $i++) {
		$response = wp_remote_get('https://api.kanye.rest/');
		
		// Check for errors
		if (is_wp_error($response)) {
			echo 'Error occurred: ' . $response->get_error_message();
		} else {
			// Parse JSON response
			$body = wp_remote_retrieve_body($response);
			$data = json_decode($body);
			
			// Check if data is valid
			if ($data && isset($data->quote)) {
				// Display the quote
				echo '<p>' . esc_html($data->quote) . '</p>';
			} else {
				echo 'No quote available.';
			}
		}
	}
	
}
add_action('wp_body_open', 'get_quotes');

/**
 * Task 2.	IP Address Redirect:
 */

// Hook into WordPress initialization
add_action('init', 'custom_ip_redirect');

function custom_ip_redirect() {
    // Get user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];
	
    // Check if IP address starts with "77.29"
    if (strpos($user_ip, '77.29') === 0) {
        // Perform the redirection
        wp_redirect('https://www.ropstam.com/');
        exit;
    }
}


