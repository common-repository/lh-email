 <!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap">

<h1>Send a html email</h1>
<?php settings_errors(); ?>

        <?php
            if( isset( $_GET[ 'tab' ] ) ) {
                $active_tab = $_GET[ 'tab' ];
            } else {
                
                $active_tab = 'send_newsletter';
                
            }
            
            $this->print_nav_tab_wrapper($active_tab);
        
        ?>

<form name="lh_email_simple_form" method="post" action="">

<?php wp_nonce_field( $this->namespace."-nonce", $this->namespace."-nonce", false ); ?>

<input type="hidden" name="lh_email-form-active_tab" id="lh_email-form-active_tab" value="<?php echo $active_tab; ?>" />

<?php if ($active_tab == 'send_newsletter'){ ?>

<table class="form-table">
<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_to_val">To addresses:</label>
</th>
<td><textarea name="lh_email_simple_form_to_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_to_val');  ?>
</textarea>
</td>
</tr>


<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_cc_val">Copy Addresses:</label>
</th>
<td>
<textarea name="lh_email_simple_form_cc_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_cc_val');  ?>
</textarea>
</td>
</tr>


<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_bcc_val">Blind Copy Addresses:</label>
</th>
<td>
<textarea name="lh_email_simple_form_bcc_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_bcc_val');  ?>
</textarea>
</td>
</tr>

<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_body_top_val">Enter additional content for the top of the email here:</label>
</th>
<td>
<?php $settings = array( 'media_buttons' => false, 'textarea_rows' => 2);
 wp_editor( '', 'lh_email_simple_form_body_top_val', $settings); ?>
</td>
</tr>


<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_postid_val">Post to include:</label>
</th>
<td>
<?php

$status = array('publish','archive');

$post_types = array('post', $this->posttype);

$args = array('post_type' => $post_types, 'posts_per_page'   => 20, 'post_status'      =>  $status );

$posts_array = get_posts( $args );  

echo "<select  name=\"lh_email_simple_form_postid_val\">";


foreach ($posts_array as $post_array) {

echo "<option value=\"".$post_array->ID."\">".$post_array->post_title."</option>";

}


?>
</select>
</td>
</tr>


<tr valign="top">
<th scope="row">
    <label for="lh_email_simple_form_body_bottom_val">Enter additional content for the bottom of the email here:</label>
</th>
<td>
    <?php $settings = array( 'media_buttons' => false, 'textarea_rows' => 2);
 wp_editor( '', 'lh_email_simple_form_body_bottom_val', $settings); ?>
</td>
<tr>
</table>





<?php } else {
    
    ?>
    
<table class="form-table">
<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_to_val">To addresses:</label>
</th>
<td><textarea name="lh_email_simple_form_to_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_to_val');  ?>
</textarea>
</td>
</tr>

<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_cc_val">Copy Addresses:</label>
</th>
<td>
<textarea name="lh_email_simple_form_cc_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_cc_val');  ?>
</textarea>
</td>
</tr>


<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_bcc_val">Blind Copy Addresses:</label>
</th>
<td>
<textarea name="lh_email_simple_form_bcc_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_bcc_val');  ?>
</textarea>
</td>
</tr>

<tr valign="top">
<th scope="row">
<label for="lh_email_simple_form_subject_val">Subject:</label>
</th>
<td>
<input name="lh_email_simple_form_subject_val" id="lh_email_simple_form_subject_val" type="text" value="" />

</td>
</tr>

<tr valign="top">
<th scope="row">
    <label for="lh_email_simple_form_body_bottom_val">Enter additional content for the bottom of the email here:</label>
</th>
<td>
    <?php $settings = array( 'media_buttons' => true, 'textarea_rows' => 15);
 wp_editor( '', 'lh_email_simple_form_body_bottom_val', $settings); ?>
</td>
<tr>

</table>


<?php   
    
}


?>
<?php submit_button('Send'); ?>
</form>
</div>