<?php

/*
Plugin Name: Riad Word Play
Plugin URI: http://dgbdesign.com/
Description: Riad Word Play game for RiadRepresents blog.
Author: David Bunde
Version: 1.0
Author URI: http://dgbdesign.com/
*/
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'riadwordplay',
		array(
			'labels' => array(
				'name' => __( 'Riad Word Play' ),
				'singular_name' => __( 'RiadWordPlay' )
			),
		'menu_position' => 5,
		'public' => true,
		'has_archive' => false,
		'map_meta_cap' => true,
		'capability_type' => 'post',
		'rewrite' => true,
		'taxonomies' => array('category','post_tag'),
		'query_var' => true
		)
	);
	add_post_type_support( 'riadwordplay','thumbnail' );
}
/*
function themes_taxonomy() {
	register_taxonomy(
		'themes_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
		'riadwordplay',   		 //post type name
		array(
			'hierarchical' 		=> true,
			'label' 			=> 'Riad Word Play',  //Display name
			'query_var' 		=> true,
			'rewrite'			=> array(
					'slug' 			=> 'play', // This controls the base slug that will display before each term
					'with_front' 	=> false // Don't display the category base before
					)
			)
		);
}
add_action( 'init', 'themes_taxonomy');

function filter_post_type_link( $link, $post) {
    if ( $post->post_type != 'riadwordplay' )
        return $link;

    if ( $cats = get_the_terms( $post->ID, 'themes_categories' ) )
        $link = str_replace( '%themes_categories%', array_pop($cats)->slug, $link );
    return $link;
}
add_filter('post_type_link', 'filter_post_type_link', 10, 2);
*/
function register_riadwordplay_styles() {

	wp_register_style( 'riadwordplay', plugins_url( 'riadwordplay.css', __FILE__ ) );
	wp_enqueue_style( 'riadwordplay' );
	//wp_enqueue_script("myUi","https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.8/jquery-ui.min.js");
	//wp_enqueue_script("myUi","https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.8/jquery-ui.min.js");
	wp_enqueue_script('riadwordplay',plugins_url('riadwordplay.js', __FILE__ ),array( 'jquery' ),array(),false, true);//,'jquery-ui-core','jquery-effects-core','jquery-effects-scale'
	
}
add_action( 'wp_enqueue_scripts', 'register_riadwordplay_styles',20 );

function get_riadwordplay_single_template($single_template) {
     global $post;

     if ($post->post_type == 'riadwordplay') {
          $single_template = dirname( __FILE__ ) . '/single-riadwordplay.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_riadwordplay_single_template' );
/*
function get_riadwordplay_archive_template($archive_template) {
     global $post;

     if (is_post_type_archive('riadwordplay')) {
          $archive_template = dirname( __FILE__ ) . '/archive-riadwordplay.php';
     }
     return $archive_template;
}
add_filter( 'archive_template', 'get_riadwordplay_archive_template' );
*/


function add_riadwordplay_to_query( $query ) {
	if ( is_home() && ($query->is_main_query())){
		$query->set( 'post_type', array( 'post', 'riadwordplay' ) );
	}elseif($query->is_archive){
		$query->set( 'post_type', array( 'post', 'riadwordplay' ) );
	}
		
	return $query;
}
add_action( 'pre_get_posts', 'add_riadwordplay_to_query' );

function add_riadwordplay_to_feed( $qv ) {
  if ( isset($qv['feed']) && !isset($qv['post_type']) )
    $qv['post_type'] = array('post', 'riadwordplay');
  return $qv;
}
add_filter( 'request', 'add_riadwordplay_to_feed' );


function add_riadwordplay_columns( $columns ) {
	/*$cols = array(
		'answer'      => __('Answer')
	);
	return array_merge($columns, $cols);
	*/
	 return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title'),
        'tumbnail' => __('Puzzle Pieces'),
        'date' => __('Date'),
        'answer'      => __('Answer')
        
    );
}
add_filter( "manage_riadwordplay_posts_columns", "add_riadwordplay_columns" );

function riadwordplay_custom_columns( $column, $post_id ) {
  switch ( $column ) {
    case "answer":
      	/* Get the post meta. */
		$answer = get_post_meta( $post_id, '_riadwordplay_meta_value_key', true );
		
		if ( empty( $answer ) ){/* If no duration is found, output a default message. */
			echo __( '[No Solution]' );
		}else{/* If there is a duration, append 'minutes' to the text string. */
			echo  __( $answer );
		}
		break;  
  }
}
add_action( "manage_riadwordplay_posts_custom_column", "riadwordplay_custom_columns", 10, 2 );

function sortable_columns() {
  return array(
    'answer'=> 'answer',
    'date'	=>'date',
    'title' =>'title'
  );
}
add_filter( "manage_edit-riadwordplay_sortable_columns", "sortable_columns" );

function obfuscate($email){
	$link = "";
	foreach(str_split($email) as $letter)
		$link .= "&#".ord($letter).";";
	return $link;
}

function riadwordplay_content_filter($content) {
  // assuming you have created a page/post entitled 'debug'
  if($GLOBALS['post']->post_type == 'riadwordplay') {
  	//$solution = "<div class=\"instructions\">What do these four images have in common? Guess the word!</div><div id=\"rwp-pieces\"><ul></ul></div><div id=\"answer\" data-word=\"".strToLower(get_post_meta(get_the_ID(), '_riadwordplay_meta_value_key',true))."\"></div><div id=\"letters\"><ul></ul></div>";
  	$solution = "<div id=\"rwpfeatured\">".get_the_post_thumbnail()."</div><div id=\"answer\" data-word=\"".strToLower(get_post_meta(get_the_ID(), '_riadwordplay_meta_value_key',true))."\"></div><div id=\"letters\"><ul></ul></div>";
   	//<div id=\"rwpfeatured\">".get_the_post_thumbnail()."</div>
    $new_content = $content.$solution;
    return  $new_content;
  }
  // otherwise returns the database content
  return $content;
}

add_filter( 'the_content', 'riadwordplay_content_filter' );

function riadwordplay_add_meta_box( $post ) {
    add_meta_box(
			'riadwordplay_sectionid',
			__( 'Puzzle Solution', 'riadwordplay_textdomain' ),
			'riadwordplay_meta_box_callback',
			'riadwordplay'
		);
}
add_action( 'add_meta_boxes', 'riadwordplay_add_meta_box' );

function riadwordplay_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'riadwordplay_meta_box', 'riadwordplay_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_riadwordplay_meta_value_key', true );

	echo '<label for="riadwordplay_new_field">';
	_e( 'Solution:', 'riadwordplay_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="riadwordplay_new_field" name="riadwordplay_new_field" value="' . esc_attr( $value ) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function riadwordplay_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['riadwordplay_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['riadwordplay_meta_box_nonce'], 'riadwordplay_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, its safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['riadwordplay_new_field'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['riadwordplay_new_field'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_riadwordplay_meta_value_key', $my_data );
}
add_action( 'save_post', 'riadwordplay_save_meta_box_data' );



?>