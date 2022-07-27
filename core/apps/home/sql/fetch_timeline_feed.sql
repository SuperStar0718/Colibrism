/*
@*************************************************************************@
@ Software author: Mansur Altamirov (Mansur_TL)							  @
@ Author_url 1: https://www.instagram.com/mansur_tl                       @
@ Author_url 2: http://codecanyon.net/user/mansur_tl                      @
@ Author E-mail: vayart.help@gmail.com                                    @
@*************************************************************************@
@ ColibriSM - The Ultimate Modern Social Media Sharing Platform           @
@ Copyright (c) 2020 - 2021 ColibriSM. All rights reserved.               @
@*************************************************************************@
 */

SELECT posts.`id` as offset_id, posts.`publication_id`, posts.`type`, posts.`user_id` FROM `<?php echo($data['t_posts']); ?>` posts
	
	INNER JOIN `<?php echo($data['t_pubs']); ?>` pubs ON posts.`publication_id` = pubs.`id`

	WHERE pubs.`status` = 'active'

	AND (posts.`user_id` = <?php echo($data['user_id']); ?> OR posts.`user_id` IN (SELECT `following_id` FROM `<?php echo($data['t_conns']); ?>` WHERE `follower_id` = <?php echo($data['user_id']); ?> AND `status` = "active"))

	AND (posts.`publication_id` NOT IN (SELECT `post_id` FROM `<?php echo($data['t_reports']); ?>` WHERE `user_id` = <?php echo($data['user_id']); ?>))

	<?php if($data['offset']): ?>
		AND posts.`id` < <?php echo($data['offset']); ?>
	<?php elseif($data['onset']): ?>
		AND posts.`id` > <?php echo($data['onset']); ?>
	<?php endif; ?>

	ORDER BY posts.`id` DESC, pubs.`likes_count` DESC, pubs.`replys_count` DESC, pubs.`reposts_count` DESC

<?php if($data['limit']): ?>
	LIMIT <?php echo($data['limit']); ?>
<?php endif; ?>