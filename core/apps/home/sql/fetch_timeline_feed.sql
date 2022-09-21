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



WITH Row_count AS(
SELECT ROW_NUMBER() OVER() AS num, posts.`id` as offset_id, posts.`publication_id`, posts.`type`, posts.`user_id`,posts.`community_id`, community.`name` FROM `<?php echo($data['t_posts']); ?>` posts
	
	INNER JOIN `<?php echo($data['t_pubs']); ?>` pubs ON posts.`publication_id` = pubs.`id`
	INNER JOIN `<?php echo($data['t_community']); ?>` community ON posts.`community_id` = community.`community_id` 
	WHERE posts.`user_id` = <?php echo($data['user_id']); ?>
	OR posts.`community_id` IN (SELECT `community_id` FROM `cl_community_following` WHERE `follow_user_id`=<?php echo($data['user_id']); ?>)
	OR posts.`user_id` IN (SELECT `people_id` FROM `cl_people_following` WHERE `user_id` = <?php echo($data['user_id']); ?>)
	ORDER BY posts.`id` DESC
)
SELECT  *  FROM Row_count 	
	<?php if($data['offset']): ?>
		WHERE num BETWEEN <?php echo($data['offset']+1); ?> AND  <?php echo($data['offset']+$data['limit']); ?> 
	<?php else: ?>
		WHERE num BETWEEN 1 AND  <?php echo($data['limit']); ?> 

	-- 	AND posts.`id` > <?php echo($data['onset']); ?>
	<?php endif; ?>
-- <?php if($data['limit']): ?>
-- 	LIMIT <?php echo($data['limit']); ?>
-- <?php endif; ?>
