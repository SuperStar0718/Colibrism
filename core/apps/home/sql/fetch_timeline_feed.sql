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





SELECT posts.`id` as offset_id, posts.`publication_id`, posts.`type`, posts.`user_id`,posts.`community_id`, community.`name` FROM `<?php echo($data['t_posts']); ?>` posts
	
	INNER JOIN `<?php echo($data['t_pubs']); ?>` pubs ON posts.`publication_id` = pubs.`id`
	INNER JOIN `<?php echo($data['t_community']); ?>` community ON posts.`community_id` = community.`community_id` 
	WHERE posts.`community_id` IN (SELECT `community_id` FROM `cl_community_following` WHERE `follow_user_id`=<?php echo($data['user_id']); ?>)
	ORDER BY posts.`id` DESC, pubs.`likes_count` DESC, pubs.`replys_count` DESC, pubs.`reposts_count` DESC

<?php if($data['limit']): ?>
	LIMIT <?php echo($data['limit']); ?>
<?php endif; ?>
