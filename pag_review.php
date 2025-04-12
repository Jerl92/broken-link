<?php
//What we need:
//count posts waiting for approval
$pag_posts = pag_get_posts_wait();
$reviewcount = count($pag_posts);
$trclass = "";
?>

<div class="wrap">
	<div class="icon32"><img src="<?php echo PAG_PLUGIN_URL.'/images/pag_32.png'; ?>" alt="pag" /></div>
	<h2><?php _e('Post as guest -  Waiting queue', 'post-as-guest') ?></h2>

		<table class="widefat">
			<thead>
				<tr>
					<th><?php _e('Id', 'post-as-guest') ?></th>
					<th><?php _e('Post title', 'post-as-guest') ?></th>
					<th><?php _e('Posted on', 'post-as-guest') ?></th>
					<th colspan="4"><?php _e('Actions', 'post-as-guest') ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="7">
						<?php
						if ( $reviewcount > 0) {
							_e('Posts currently waiting for approval: ', 'post-as-guest'); echo('<span id="rcount">'.$reviewcount.'</span>');
						} else {
							_e('You currently have no post for approval.', 'post-as-guest');
						}
						?>
					</td>
				</tr>
				<?php
				foreach ($pag_posts as $pag_post ) {
					echo "<tr id=\"pagpost-{$pag_post->ID}\" class=\"$trclass\">";
					echo "<td>". $pag_post->ID."</td>\n";
					echo "<td>". $pag_post->post_title."</td>\n";
					echo "<td>". $pag_post->post_date."</td>\n";
					echo "<td><a class='view' href='javascript:pagpreview({$pag_post->ID})'>".__('Preview', 'post-as-guest')."</a></td>\n";
					echo "<td><a class='view' href='post.php?post={$pag_post->ID}&action=edit'>".__('Edit', 'post-as-guest')."</a></td>\n";
					echo "<td><a class='view' href='javascript:pagapprove({$pag_post->ID})'>".__('Approve', 'post-as-guest')."</a></td>\n";
					echo "<td><a class='view' href='javascript:pagremove({$pag_post->ID})'>".__('Remove', 'post-as-guest')."</a></td>\n";
					echo "</tr>";
					$trclass = empty($trclass)?"alternate":"";
				}
				?>
			</tbody>
		</table>
	</div>
</div>