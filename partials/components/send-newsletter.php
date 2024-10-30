<form name="lh_email_simple_form" method="post" action="">
<input type="hidden" name="<?php echo $this->hidden_field_name; ?>" value="Y" />
<p>To addresses:<br/>
<textarea name="lh_email_simple_form_to_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_to_val');  ?>
</textarea>
</p>

<p>Copy Addresses:<br/>
<textarea name="lh_email_simple_form_cc_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_cc_val');  ?>
</textarea>
</p>

<p>Blind Copy Addresses:<br/>
<textarea name="lh_email_simple_form_bcc_val" value="" rows="2" cols="50">
<?php  do_action('lh_email_bcc_val');  ?>
</textarea>
</p>


<p>Enter additional content for the top of the email here:<br/>
<textarea name="lh_email_simple_form_body_top_val" rows="9" cols="75">
</textarea>


<p>Post to include:<br/>

<?php

$status = array('publish','archive');

$args = array('posts_per_page'   => 20, 'post_status'      =>  $status );

$posts_array = get_posts( $args );  

echo "<select  name=\"lh_email_simple_form_postid_val\">";


foreach ($posts_array as $post_array) {

echo "<option value=\"".$post_array->ID."\">".$post_array->post_title."</option>";

}

echo "</select></p>";

?>

<p>Enter additional content for the bottom of the email here:<br/>
<textarea name="lh_email_simple_form_body_bottom_val" rows="9" cols="75">
</textarea>




<?php submit_button(); ?>

</form>