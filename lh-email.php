<?php 
/*
Plugin Name: LH Email
Plugin URI: https://lhero.org/plugins/lh-email/
Description: Do email newsletters the LH way
Version: 1.12
Author: Peter Shaw
Author URI: https://shawfactor.com/
*/


if (!class_exists('LH_email_plugin')) {

class LH_email_plugin {

var $filename;
var $namespace = 'lh_email';
var $allow_email_field_name = 'lh_email-allow_email';
var $to_email_field_name  = 'lh_email-to_email';
var $post_status_field_name = 'lh_email-post_status';
var $top_content_field_name = 'lh_email-top_content';
var $bottom_content_field_name = 'lh_email-bottom_content';
var $posttype = 'lh-email-newsletter';

private static $instance;

private function register_newsletter_post_type() {


$label = 'Messages';

$labels = array(
    'name' => 'Newsletter',
      'singular_name' => 'Newsletter',
      'menu_name'	=> 'Newsletters',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Newsletter',
      'edit' => 'Edit newsletter',
      'edit_item' => 'Edit Newsletter',
      'new_item' => 'New Newsletter',
      'view' => 'View Newsletter',
      'view_item' => 'View Newsletter',
      'search_items' => 'Search Newsletters',
      'not_found' => 'No newsletters Found',
      'not_found_in_trash' => 'No newsletters Found in Trash');


register_post_type($this->posttype, array(
        'label' => $label,
        'description' => '',
        'public' => true,
        'show_ui' => true,
        'show_in_nav_menus'  => false,
        'show_in_rest' => true,
        'hierarchical' => false,
        'supports' =>  array( 'title', 'editor', 'author', 'thumbnail'),
        'labels' => $labels,
        'show_in_menu'  => 'tools.php?page=lh-email%2Flh-email.php',
        )
    );



}



private function array_fix( $array )    {
        return array_filter(array_map( 'trim', $array ));

}

private function is_post_object_emailable($post) {

if ($post->post_type == "post"){

return true;


} else {


return false;


}


}

private function print_nav_tab_wrapper($active_tab){
    
    ?>
    
           <h2 class="nav-tab-wrapper">
            <a href="?page=<?php echo $this->filename;  ?>&tab=send_newsletter" class="nav-tab <?php echo $active_tab == 'send_newsletter' ? 'nav-tab-active' : ''; ?>">Send Newsletter</a>
            <a href="?page=<?php echo $this->filename;  ?>&tab=send_email" class="nav-tab <?php echo $active_tab == 'send_email' ? 'nav-tab-active' : ''; ?>">Send Email</a>
            <a href="<?php echo admin_url('edit.php?post_type=').$this->posttype;  ?>" class="nav-tab">Newsletters</a>
        </h2>
        
        <?php
    
    
    

}


private function use_email_template( $message, $post) {


$dir = get_stylesheet_directory().'/'.$this->namespace.'-template.php';



if (file_exists($dir)){


ob_start();

include( get_stylesheet_directory().'/'.$this->namespace.'-template.php');

$message = ob_get_contents();

ob_end_clean();


} else {

ob_start();

include( plugin_dir_path( __FILE__ ).'/'.$this->namespace.'-template.php');

$message = ob_get_contents();

ob_end_clean();


}


if (!class_exists('CssToInlineStyles')) {


require_once('csstoinlinestyles/CssToInlineStyles.php');


}


$doc = new DOMDocument();

$doc->loadHTML($message);

// create instance
$cssToInlineStyles = new CssToInlineStyles();

$cssToInlineStyles->setHTML($message);

$cssToInlineStyles->setCSS($doc->getElementsByTagName('style')->item(0)->nodeValue);

// output

$message = $cssToInlineStyles->convert(); 

return $message;

}


public function add_new_image_sizes() {

 add_image_size( 'lh-email-featured', 960, 300, true ); 

}

public function template_sidebar_registration(){

if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name'=> 'LH Email Sidebar',
		'id' => 'lh_email_sidebar',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="offscreen">',
		'after_title' => '</h2>',
	));


	register_sidebar(array(
		'name'=> 'LH Email Footer',
		'id' => 'lh_email_footer',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));

}
}


public function send_form(){

$return_string = '';

ob_start();



// Now display the newsletter tools screen
include ('partials/send-newsletter-tools.php');


$return_string .= ob_get_contents();
ob_end_clean();

return $return_string;

}


public function plugin_menu() {
add_submenu_page( 'tools.php', 'Send Email', 'Send Email', 'manage_options', $this->filename, array($this,"plugin_options") );






}

public function plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}




if( isset($_POST[ $this->namespace."-nonce" ]) && wp_verify_nonce($_POST[ $this->namespace."-nonce" ], $this->namespace."-nonce" )) {

$to = $_POST['lh_email_simple_form_to_val'];




if (isset($_POST['lh_email_simple_form_subject_val']) and !empty(trim($_POST['lh_email_simple_form_subject_val']))){

$subject = $_POST['lh_email_simple_form_subject_val'];

}

$headers = array('Content-Type: text/html; charset=UTF-8');


if (isset($_POST['lh_email_simple_form_cc_val']) and !empty(trim($_POST['lh_email_simple_form_cc_val']))){

$headers[] = "Cc: ".$_POST['lh_email_simple_form_cc_val'];

}

if (isset($_POST['lh_email_simple_form_bcc_val']) and !empty(trim($_POST['lh_email_simple_form_bcc_val']))){

$headers[] = "BCC: ".$_POST['lh_email_simple_form_bcc_val'];

}


if (isset($_POST['lh_email_simple_form_postid_val']) and !empty($_POST['lh_email_simple_form_postid_val'])){

$post = get_post($_POST['lh_email_simple_form_postid_val']);

$message = $_POST['lh_email_simple_form_body_top_val'];

$message .= str_replace("[lh_personalised_content", "[[lh_personalised_content", $post->post_content);

$message = str_replace("/lh_personalised_content]", "/lh_personalised_content]]", $message);

$message .= $_POST['lh_email_simple_form_body_bottom_val'];

$message = wpautop(do_shortcode($message));

$subject = $post->post_title;


$message = $this->use_email_template( $message , $post );


} else {
    
$subject = $_POST['lh_email_simple_form_subject_val'];
    
    
$message = $_POST['lh_email_simple_form_body_bottom_val']; 
$message = wpautop(do_shortcode($message));
$message = '<html><body>'.$message.'</body></html>';
    
}



/////////////////////////

echo $message;

if (class_exists('LH_Email_queue_plugin')) {
    
    $args['subject'] = $subject;
    $args['message'] = $message;
    $args['headers'] = $headers;
    
    $arr = explode(',', $to);
    
foreach ($arr as $value) {
    $recipients[] = trim($value);
}

foreach ($recipients as $recipient) {
    
    $args['to'] = $recipient;
    
    LH_Email_queue_plugin::queue_wp_mail( $args );
    
}
    
} else {


wp_mail( $to, $subject, $message, $headers );

}


} else {


// Now display the tools screen
include ('partials/tools.php');



}

}


public function create_taxonomies() {


	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Email Statuses', 'taxonomy general name' ),
		'singular_name'     => _x( 'Email Status', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Statuses' ),
		'all_items'         => __( 'All Email Statuses' ),
		'edit_item'         => __( 'Edit Status' ),
		'new_item_name'     => __( 'New Status Name' ),
		'menu_name'         => __( 'Email Status' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => false,
		'show_admin_column' => true,
            	'public' => false,
            	'rewrite' => false
	);

	register_taxonomy( 'lh_email-tax-status', array( 'post', 'page'), $args );





}

public function on_activate( $network){

wp_insert_term( "Draft", 'lh_email-tax-status', $args = array() );
wp_insert_term( "Active", 'lh_email-tax-status', $args = array() );
wp_insert_term( "Archived", 'lh_email-tax-status', $args = array() );  

}

public function editor_form_metabox_content(){

global $post;

if (!has_term( '', 'lh_email-tax-status', $post )){


?>
<table>
<tbody>
<tr>
<td>
<label id="<?php  echo $this->allow_email_field_name;  ?>-label" for="<?php  echo $this->allow_email_field_name;  ?>">Email this <?php  echo $post->post_type;  ?>:</label>
</td>
<td>
<input type="checkbox" name="<?php  echo $this->allow_email_field_name;  ?>" id="<?php  echo $this->allow_email_field_name;  ?>" value="1" />
(<a href="https://lhero.org/plugins/lh-email/#<?php echo $this->allow_email_field_name; ?>">What does this mean?</a>)
</td>
</tr>
</tbody>
</table>





<?php

} else {


$to_email_field = get_post_meta( $post->ID, "_".$this->to_email_field_name, false );

$top_content_field = get_post_meta( $post->ID, "_".$this->top_content_field_name, true );
$bottom_content_field = get_post_meta( $post->ID, "_".$this->bottom_content_field_name, true );

?>

<table>
<tbody>
<tr>
<td>
<label id="<?php  echo $this->post_status_field_name;  ?>-label" for="<?php  echo $this->post_status_field_name;  ?>">Logged the confirmed User in:</label>
</td>
<td>

<?php $terms = get_terms('lh_email-tax-status', array('hide_empty'    => false )); 

$term_list = wp_get_post_terms($post->ID, 'lh_email-tax-status', array("fields" => "all"));

?>
<select name="<?php echo $this->post_status_field_name; ?>" id="<?php echo $this->post_status_field_name; ?>">
<?php foreach ( $terms as $term ) : ?>
<option value="<?php echo esc_attr( $term->slug ); ?>" <?php if ($term_list[0]->slug == $term->slug) { echo 'selected="selected"'; } ?>><?php echo esc_html( $term->name ); ?></option>
<?php endforeach; ?>
</select>
(<a href="https://lhero.org/plugins/lh-email/#<?php echo $this->post_status_field_name; ?>">What does this mean?</a>)
</td>
</tr>
</tbody>
</table>
<p>To addresses:<br/>
<textarea name="<?php echo $this->to_email_field_name; ?>" rows="2" cols="50">
<?php echo implode(",", $to_email_field); ?>
</textarea>
</p>
<p>Enter additional content for the top of the email here:<br/>
<?php $settings = array( 'media_buttons' => false, 'textarea_rows' => 5);
 wp_editor( $top_content_field, $this->top_content_field_name, $settings); ?>



<p>Enter additional content for the bottom of the email here:<br/>
<?php wp_editor( $bottom_content_field, $this->bottom_content_field_name, $settings); ?>


<?php

}


}







public function setup_post_types() {


$this->register_newsletter_post_type();

 

}

function add_user_rows($actions,$user) {


$url = admin_url('tools.php?page=').$this->filename.'&tab=send_email';

$url = add_query_arg( 'user_id', $user->ID, $url);

$actions['send_email_link']  = '<a href="'.$url.'" title="' . esc_attr( __( 'Email this user' ) ) . '">' . __( 'Email' ) . '</a>';

return $actions;

}

public function lh_email_to_val(){
    
    
if (isset($_GET['user_id']) and is_numeric($_GET['user_id'])){
    
$user_obj = get_user_by('id', $_GET['user_id']);

echo $user_obj->user_email;
    
    
} elseif (isset($_GET['post']) and is_numeric($_GET['post'])){
    
$users = get_users( array(
  'connected_type' => array('lh_teams_confirmed_team_member','lh_teams_unconfirmed_team_member'),
  'connected_items' => $_GET['post']
) );


foreach ( $users as $user ) { 

echo $user->user_email;
echo ",";

    
}
    
    
} elseif (isset($_GET['gid']) and is_numeric($_GET['gid'])){
    

    
$members = groups_get_group_members( array(  'group_id' => $_GET['gid'], 'exclude_admins_mods' => false ) );

foreach ( $members['members'] as $user ) { 

echo $user->user_email;
echo ",";

    
}
    
    
    
}
    
    
}

    /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }


public function __construct() {

$this->filename = plugin_basename( __FILE__ );

add_action( 'init', array($this,"add_new_image_sizes"));
add_action( 'wp_loaded', array($this,"template_sidebar_registration"));
add_action( 'admin_menu', array($this,"plugin_menu"));
add_action( 'init', array($this,"create_taxonomies"), 2 );


//Register custom post type 
add_action('init', array($this,"setup_post_types"));

//add an email user link to user actions
add_filter('user_row_actions',array($this,"add_user_rows"),10,2);


//automatically add emails to the to field
add_action( 'lh_email_to_val', array($this,"lh_email_to_val"));

}



}

$lh_email_instance = LH_email_plugin::get_instance();
register_activation_hook(__FILE__, array($lh_email_instance,'on_activate'), 10, 1);

}



?>