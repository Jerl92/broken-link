<?php
/*
Plugin Name: Broken link
Description: Broken link - Creates a form (shortcode) to a page to allow guests to post
Version: 0.9.9
License: GPLv2
Author: Thomas Ehrhardt & Jerl92
Author URI: https://powie.de
Text Domain: Broken-link
Domain Path: /languages
*/

//Define some stuff
define( 'PAG_PLUGIN_DIR', dirname( plugin_basename( __FILE__ ) ) );
define( 'PAG_PLUGIN_URL', plugins_url( dirname( plugin_basename( __FILE__ ) ) ) );
load_plugin_textdomain( 'post-as-guest', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

//create custom plugin settings menu
add_action('admin_menu', 'pag_create_menu');
add_action('admin_init', 'pag_register_settings' );
//add_action('wp_head', 'plinks_websnapr_header');
//Shortcode
add_shortcode('broken_link_submit_front_from', 'pag_shortcode');
//Hook for Activation
register_activation_hook( __FILE__, 'pag_activate' );
//Hook for Deactivation
register_deactivation_hook( __FILE__, 'pag_deactivate' );

//PAG Ajax Javascripts Admin
function pagjs(){
	wp_enqueue_script( 'pagjs', PAG_PLUGIN_URL.'/pag.js', array('jquery'), '1.0' );
}
add_action( 'admin_init', 'pagjs' );

//Nonces!!! nont nonsens :)
add_action('init','pagnonces_create');
function pagnonces_create(){
	$pagnonce = wp_create_nonce('pagnonce');
}

//PAG JS Frontend
// thanks to http://www.garyc40.com/2010/03/5-tips-for-using-ajax-in-wordpress/
// embed the javascript file that makes the AJAX request
function pagfejs(){
	wp_enqueue_script( 'pagajaxrequest', plugin_dir_url( __FILE__ ) . 'pagfe.js', array( 'jquery' ) );
	wp_localize_script( 'pagajaxrequest', 'PagAjax',
		array(  'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'enter_title' => __('Quelle série ?', 'post-as-guest'),
			'enter_content' => __('Il manque quelle que chose d' . "'" . 'important', 'post-as-guest' )
		)
	);
	//reCaptcha:
	wp_enqueue_script( 'recaptchaapi', 'https://www.google.com/recaptcha/api.js', $deps = array(), $ver = false, $in_footer = false );
}
add_action( 'wp_enqueue_scripts', 'pagfejs' );


// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)

/**
 * Broken Link
 *
 * Snippet by GenerateWP.com
 * Generated on October 29, 2017 04:43:22
 * @link https://generatewp.com/snippet/6Xg2WYX/
 */


// Register Custom Post Type
function broken_link() {
	
	$labels = array(
		'name'                  => _x( 'Broken Links', 'Post Type General Name', 'broken_link' ),
		'singular_name'         => _x( 'Broken Link', 'Post Type Singular Name', 'broken_link' ),
		'menu_name'             => __( 'Broken Links', 'broken_link' ),
		'name_admin_bar'        => __( 'Broken Link', 'broken_link' ),
		'archives'              => __( 'Broken Links Archives', 'broken_link' ),
		'attributes'            => __( 'Broken Links Attributes', 'broken_link' ),
		'parent_item_colon'     => __( 'Parent Broken Links:', 'broken_link' ),
		'all_items'             => __( 'All Broken Links', 'broken_link' ),
		'add_new_item'          => __( 'Add Broken Link', 'broken_link' ),
		'add_new'               => __( 'Add New', 'broken_link' ),
		'new_item'              => __( 'New Broken Link', 'broken_link' ),
		'edit_item'             => __( 'Edit Broken Link', 'broken_link' ),
		'update_item'           => __( 'Update Broken Link', 'broken_link' ),
		'view_item'             => __( 'View Broken Link', 'broken_link' ),
		'view_items'            => __( 'View Broken Links', 'broken_link' ),
		'search_items'          => __( 'Search Broken Link', 'broken_link' ),
		'not_found'             => __( 'Not found', 'broken_link' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'broken_link' ),
		'featured_image'        => __( 'Featured Image', 'broken_link' ),
		'set_featured_image'    => __( 'Set featured image', 'broken_link' ),
		'remove_featured_image' => __( 'Remove featured image', 'broken_link' ),
		'use_featured_image'    => __( 'Use as featured image', 'broken_link' ),
		'insert_into_item'      => __( 'Insert into Broken Link', 'broken_link' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Broken Link', 'broken_link' ),
		'items_list'            => __( 'Broken Link list', 'broken_link' ),
		'items_list_navigation' => __( 'Broken Links list navigation', 'broken_link' ),
		'filter_items_list'     => __( 'Filter Broken Link list', 'broken_link' ),
	);
	$args = array(
		'label'                 => __( 'Broken Link', 'broken_link' ),
		'description'           => __( 'Broken link CPT', 'broken_link' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'comments', 'editor', ),
		'taxonomies'            => false,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-editor-unlink',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => false,
		'has_archive'           => true,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'broken_link', $args );

}
add_action( 'init', 'broken_link', 0 );	

//Create Menus
function pag_create_menu() {
	// create PAG menu page
	//	add_menu_page( __('Post as Guest','post-as-guest'), __('Post as Guest','post-as-guest'), 'manage_options', PAG_PLUGIN_DIR.'/pag_review.php','',PAG_PLUGIN_URL.'/images/pag.png');
	//	add_submenu_page( PAG_PLUGIN_DIR.'/pag_review.php', __('Settings','post-as-guest'), __('Settings','post-as-guest'), 'manage_options', PAG_PLUGIN_DIR.'/pag_settings.php');
}

function pag_register_settings() {
	//register settings
	register_setting( 'pag-settings', 'postfield-rows', 'intval' );				//Zeilen Textarea
	register_setting( 'pag-settings', 'postfield-legend');						//Bezeichnung
	register_setting( 'pag-settings', 'prepost-code');
	register_setting( 'pag-settings', 'afterpost-code' );
	register_setting( 'pag-settings', 'after-post-msg' );
	register_setting( 'pag-settings', 'category-select', 'intval' );			//Auswahl der Kategorie gestatten
	register_setting( 'pag-settings', 'default-categoryid', 'intval' );			//Auswahl der Standard Kategorie
	register_setting( 'pag-settings', 'notify-admin', 'intval' );				//Admin Benachrichtigung 1 / 0
	register_setting( 'pag-settings', 'notify-email' );							//Admin eMail Adresse
	register_setting( 'pag-settings', 'rc-site-key' );							//ReCpatcha Site Key
	register_setting( 'pag-settings', 'rc-secret-key' );						//ReCpatcha Secret Key
}

function pag_shortcode( $atts ) {
	//var_Dump($atts);
	/*
	extract( shortcode_atts( array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts ) );
	return "Hallo -> foo = {$foo}";
	*/

	$sc = '<!-- post-as-guest -->';
	$sc.= '<div id="pag_form"><form method="post" id="pag" action="">
			<input type="hidden" name="action" value="pag_post" />';
    $sc.= wp_nonce_field( 'pagnonce', 'post_nonce', true, false );
	$sc.= '	<legend>Nom de la série</legend>
        	<input type="text" name="pagtitle" id="pagtitle" />
			<br />
			<legend>Numero de la saison</legend>
			<input type="number" min="1" max="99" name="broken_link_se" style="color: #000" id="broken_link_se" />
			</br>
			<legend>Numero de l&#39;episode</legend>
			<input type="number" min="1" max="99" name="broken_link_ep" style="color: #000;" id="broken_link_ep" />
			<br />
			<legend>Lien URL</legend>
			<input type="text" name="pagcontent" id="pagcontent" />
			<br />';
	if (get_option('rc-secret-key') != "") {
		$sc.='<br /><br /><div class="g-recaptcha" data-sitekey="'.get_option('rc-site-key').'"></div><br />';
	}
    $sc.='<input type="submit" id="pagsubmit" name="pagsubmit" value="'.__("Envoyer", 'post-as-guest').'" /></form>
		   </div>';
	$sc.='<!-- /post-as-guest -->';
	return $sc;

	// broken_link
	// broken_link_url_
	// broken_link_title_
	// broken_link_se_
	// broken_link_ep_
}

//Activate
function pag_activate() {
	// do not generate any output here
	add_option('postfield-rows',5);
	add_option('after-post-msg', __('Merci de m&#39;avertir du lien non fonctionnel !','post-as-guest'));
}

//Deactivate
function pag_deactivate() {
	// do not generate any output here
}

//Post as Guest - get count of pages waiting for review
function pag_get_posts_wait_count(){
	$args = array( 'post_type' => 'post', 'post_status' => 'review', 'numberposts' => 100 );
	$data =get_posts($args);
	return(count($data));
}

function pag_get_posts_wait(){
	$args = array( 'post_type' => 'post', 'post_status' => 'pending', 'orderby' => 'post_date', 'order' => 'DESC',
					'numberposts' => 100 );
	return get_posts($args);
}

//Ajax Functions Backend!
// Post Preview
add_action('wp_ajax_pag_post_preview', 'pag_post_preview');
function pag_post_preview(){
	$id = intval($_POST['id']);
	$post = get_post($id);
	$content =  apply_filters('the_content', esc_html($post->post_content));
	$output = "<tr class=\"pag_preview\" id=\"preview-{$post->ID}\">";
	$output.= "    <td colspan=\"7\">$content</td>\n";
	$output.= "</tr>";
	echo $output;
	die();
}
//Remove Post
add_action('wp_ajax_pag_post_remove', 'pag_post_remove');
function pag_post_remove(){
	$id = intval($_POST['id']);
	wp_delete_post($id);
	$response = json_encode( array( 'success' => true ) );
	header( "Content-Type: application/json" );
	echo $response;
	die();
}
//Approve Post
add_action('wp_ajax_pag_post_approve', 'pag_post_approve');
function pag_post_approve(){
	$id = intval($_POST['id']);
	wp_publish_post($id);
	$response = json_encode( array( 'success' => true ) );
	header( "Content-Type: application/json" );
	echo $response;
	die();
}

//Recaptcha Verify a Response Token
function pag_rcverify($response_token) {
	$is_human = false;
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$apiresponse = wp_safe_remote_post( $url, array(
				'body' => array(
				'secret' => get_option('rc-secret-key'),
				'response' => $response_token,
				'remoteip' => $_SERVER['REMOTE_ADDR'] ) ) );

		if ( 200 != wp_remote_retrieve_response_code( $apiresponse ) ) {
			return $is_human;
		}

		$apiresponse = wp_remote_retrieve_body( $apiresponse );
		$apiresponse = json_decode( $apiresponse, true );

		$is_human = isset( $apiresponse['success'] ) && true == $apiresponse['success'];
		return $is_human;
}

//Ajax Function Frontend
add_action('wp_ajax_pag_post', 'pag_post');
add_action('wp_ajax_nopriv_pag_post', 'pag_post' );
function pag_post(){
	$is_human = true;
	//ccheck nonce
	if (! wp_verify_nonce($_POST['post_nonce'], 'pagnonce') ) die('Security check');
	//check recpatcha
    if (get_option('rc-secret-key') != "") {
		$is_human = pag_rcverify($_POST['g-recaptcha-response']);
	}
	$content = trim(get_option('prepost-code')).trim($_POST['pagcontent']).trim(get_option('afterpost-code'));
	$content = sanitize_text_field($content);

	if (substr($content, 0, 8) == 'https://') {
		$content_clear = str_replace('https://', '', $content);
	}

	if (substr($content, 0, 7) == 'http://') {
		$content_clear = str_replace('http://', '', $content);
	}

	$content_clean = str_replace('www.', '', $content_clear);
	$content_pure = str_replace('.html', '', $content_clean);

	$title = sanitize_title($_POST['pagtitle']);
	if (get_option('category-select') == 1) {
		$post = array(  'post_title' => $title,
						'post_content' => $content_pure,
						'post_type' => 'broken_link',
						'post_category' => array(intval($_POST['categoryid'])),
						'post_status' => 'private');
	} else {
		$post = array(  'post_title' => $title,
						'post_content' => $content_pure,
						'post_type' => 'broken_link',
						'post_status' => 'private');
	}
	if ( $is_human ) {

		$user_ip = $_SERVER['REMOTE_ADDR'];

		// get post
		$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'broken_link',
			'post_status'      => 'private'
		);
		$posts_array = get_posts( $args ); 
		$same_content = 0;

		foreach ( $posts_array as $post_array ){
			if  ( esc_attr($post_array->post_content) == esc_attr($content_pure)) {
				$same_content = 1;
			} 
		}

		if ( ! empty($_POST['broken_link_se']) || ! empty($_POST['broken_link_ep']) ){

			if  ($same_content == 0) {
				$id = wp_insert_post( $post, false );
				add_post_meta($id, 'broken_link_se_', $_POST['broken_link_se'], true);
				add_post_meta($id, 'broken_link_ep_', $_POST['broken_link_ep'], true);
				add_post_meta($id, 'broken_link_ip_', $user_ip, true);
				$response = json_encode( array( 'success' => true ,
											'msg' => __('Merci de m&#39;avertir du lien non fonctionnel !','post-as-guest')));
			} else if  ($same_content == 1) {
				$response = json_encode( array( 'success' => true ,
				'msg' => 'Merci le lien a dêja été reporté' ) );
			}

		} 
	} else {
		$response = json_encode( array( 'error' => true ,
								    'msg' => __('Spam Check Error', 'post-as-guest') ) );		
	}
	header( "Content-Type: application/json" );
	echo $response;
	die();
}

function pag_notify($posttitle){
	//prepare
	$msg = __('A new guest post is added at ','post-as-guest').get_bloginfo()."<br /><br />";
	$msg.= __('Title', 'post-as-guest').': '.$posttitle."<br /><br />";
	$msg.= site_url();
	$title = get_bloginfo().' - '.__('New Guest Post','post-as-guest');
	//header
	$header1  = 'MIME-Version: 1.0' . "\r\n";
	$header1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$header1 .= 'From: '.get_bloginfo().' <'.get_bloginfo('admin_email').'>'."\r\n";
	//send
	mail(get_option('notify-email'), $title, $msg, $header1);
	return true;
}

    ////////////////////////////
    //
    //  my_edit_music_columns( $columns )
    //  Music CPT admin colums
    //
    ///////////////////////////
    function my_edit_music_columns( $columns ) {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Seris' ),
			'senb' => __( 'Saison' ),
			'epnb' => __( 'Episode' ),
			'link' => __( 'Lien' ),
			'ip_info' => __( 'IP' ),
			'date' => __( 'Date' )
		);

		return $columns;
	}
	add_filter( 'manage_edit-broken_link_columns', 'my_edit_music_columns' ) ;

	////////////////////////////
    //
    //  my_manage_music_columns( $column, $post_id )
    //  Music CPT admin colums, case
    //
    ///////////////////////////
    function my_manage_music_columns( $column, $post_id ) {
        global $post;

        switch( $column ) {

            case 'senb' :
            // Retrieve post meta
            $senb = get_post_meta( $post->ID, 'broken_link_se_', true );
            
            // Echo output and then include break statement
            echo '#' . $senb;
			break;			
			
            case 'epnb' :
            // Retrieve post meta
            $epnb = get_post_meta( $post->ID, 'broken_link_ep_', true );
            
            // Echo output and then include break statement
            echo '#' . $epnb;
			break;
			
			case 'link' :
            // Retrieve post meta
            $link = get_post_field('post_content',  $post->ID);
            
            // Echo output and then include break statement
            echo $link;
			break;
			
			case 'ip_info' :
            // Retrieve post meta
            $ip_ = get_post_meta( $post->ID, 'broken_link_ip_', true);
            
            // Echo output and then include break statement
            echo $ip_;
            break;

            /* Just break out of the switch statement for everything else. */
            default :
                break;
        }
    }
    add_action( 'manage_broken_link_posts_custom_column', 'my_manage_music_columns', 10, 2 );
?>