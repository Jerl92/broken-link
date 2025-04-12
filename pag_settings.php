<div class="wrap">
<div class="icon32" id="icon-options-general"></div>
<h2><?php _e('Post as guest Settings', 'post-as-guest') ?></h2>
<form method="post" action="options.php">
<?php
settings_fields( 'pag-settings' );
if  ( get_option('postfield-legend') == '' ) {
	update_option('postfield-legend',__('Post Content','post-as-guest'));
}
?>
<div id="poststuff">
<div class="postbox">
<h3><?php _e('Form Settings', 'post-as-guest') ?></h3>
	<div class="inside">
    <table class="form-table">
        <tr valign="top">
        	<th scope="row"><?php _e('Post Field Rows', 'post-as-guest') ?></th>
        	<td><input type="text" size="10" name="postfield-rows" value="<?php echo get_option('postfield-rows'); ?>" /></td>
        </tr>
        <tr valign="top">
        	<th scope="row"><?php _e('Post Field Legend', 'post-as-guest') ?></th>
        	<td><input type="text" size="50" name="postfield-legend" value="<?php echo get_option('postfield-legend'); ?>" /></td>
        </tr>

        <tr valign="top">
	        <th scope="row"><?php _e('User can select Category', 'post-as-guest') ?></th>
    	    <td><input type="checkbox" name="category-select" id="category-select" value="1" <?php checked(get_option('category-select'), 1); ?> /></td>
        </tr>

        <tr valign="top">
	        <th scope="row"><?php _e('Default Category', 'post-as-guest') ?></th>
    	    <td>
			   <select id="default-categoryid" name="default-categoryid">
					<option value=""><?php _e('-- Please Select Category','post-as-guest'); ?></option>
					<?php
						$categories = get_categories('hierarchical=0&hide_empty=0');
						foreach($categories as $category)	{
							$selected = ( get_option('default-categoryid') == $category->cat_ID ) ? 'selected' : '';
							echo '<option '.$selected.' value="'.$category->cat_ID.'">'.$category->cat_name.'</option>';
						}
					?>
				</select>
			</td>
        </tr>

    </table>
    </div>
</div>

<div class="postbox">
<h3><?php _e('Guest post settings', 'post-as-guest') ?></h3>
	<div class="inside">
    <table class="form-table">
        <tr valign="top">
        	<th scope="row"><?php _e('Add before post', 'post-as-guest') ?></th>
        	<td><textarea rows="3" name="prepost-code" style="width:100%;"><?php echo get_option('prepost-code'); ?></textarea></td>
        </tr>
        <tr valign="top">
        	<th scope="row"><?php _e('Add after post', 'post-as-guest') ?></th>
        	<td><textarea rows="3" name="afterpost-code" style="width:100%;"><?php echo get_option('afterpost-code'); ?></textarea></td>
        </tr>
        <tr valign="top">
        	<th scope="row"><?php _e('Message after post', 'post-as-guest') ?></th>
        	<td><textarea rows="2" name="after-post-msg" style="width:100%;"><?php echo get_option('after-post-msg'); ?></textarea></td>
        </tr>

    </table>
    </div>
</div>

<div class="postbox">
<h3><?php _e('Notification settings', 'post-as-guest') ?></h3>
	<div class="inside">
    <table class="form-table">
        <tr valign="top">
	        <th scope="row"><?php _e('Send notifications', 'post-as-guest') ?></th>
    	    <td><input type="checkbox" name="notify-admin" id="notify-admin" value="1" <?php checked(get_option('notify-admin'), 1); ?> /></td>
        </tr>
        <tr valign="top">
        	<th scope="row"><?php _e('Notifications eMail', 'post-as-guest') ?></th>
        	<td>
        		<input type="text" size="100" name="notify-email" value="<?php echo get_option('notify-email'); ?>" /><br />
        		<?php  _e('Seperate multiple eMail adresses with a comma', 'post-as-guest') ?>
        	</td>
        </tr>
    </table>
    </div>
</div>

<div class="postbox">
<h3><?php _e('reCaptcha Support', 'post-as-guest') ?></h3>
	<div class="inside">
    <table class="form-table">
	    <tr>
			 <td colspan="2">
			 	<?php _e('If you like to use Recaptch add your keys here', 'post-as-guest') ?>
				( <a href="https://www.google.com/recaptcha/intro/index.html" target="_blank">Google Recaptcha</a> )
			 </td>
		</tr>
        <tr valign="top">
        	<th scope="row"><?php _e('reCaptcha Site Key', 'post-as-guest') ?></th>
        	<td>
        		<input type="text" size="100" name="rc-site-key" value="<?php echo get_option('rc-site-key'); ?>" />
        	</td>
        </tr>
        <tr valign="top">
        	<th scope="row"><?php _e('reCaptcha Secret Key', 'post-as-guest') ?></th>
        	<td>
        		<input type="text" size="100" name="rc-secret-key" value="<?php echo get_option('rc-secret-key'); ?>" />
        	</td>
        </tr>
    </table>
    </div>
</div>

</div>
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</form>
<br />

<div id="poststuff">
<div class="postbox">
<h3><?php _e('Post as guest Usage', 'post-as-guest') ?></h3>
	<div class="inside">
		<?php _e('Simple use a shortcode on a page of your choice or create a new page and insert the following shortcode: <code>[post-as-guest]</code> to show the guest form.', 'post-as-guest') ?>
    </div>
</div>

<div class="postbox">
<h3><?php _e('About', 'post-as-guest') ?></h3>
	<div class="inside" style="overflow:auto">
		<div style="float:left;margin-right: 10px; display:inline;">
		<!-- www -->
		WWW: <a href="https://powie.de">powie.de</a>
		</div>
		<div style="float:left;margin-right: 10px; display:inline;">
		<!-- twitter -->
		<a href="https://twitter.com/PowieT" class="twitter-follow-button" data-show-count="false" data-lang="de">@PowieT folgen</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<div style="float:left;margin-right: 10px; display:inline;">
		<!-- fb -->
		<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpowiede&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:350px; height:35px;" allowTransparency="true"></iframe>
		</div>

		<div style="float:left;margin-right: 10px; display:inline;">
			<div class="g-plusone" data-size="small" data-href="https://powie.de"></div>
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		</div>

    </div>
</div>
</div>
</div>